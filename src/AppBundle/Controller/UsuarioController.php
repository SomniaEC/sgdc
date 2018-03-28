<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Utils\ConstantesDeOperaciones;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends BaseController
{

    /**
     * @Route("/usuario/crearSuperAdmin", name="crear_super_admin")
     */
    public function createSuperAdminAction()
    {
        $usuario = new Usuario(); $randomInt = rand();
        $usuario->setCedula($randomInt);
        $usuario->setUsername('admin' . $randomInt);
        $usuario->setEmail('admin' . $randomInt . '@admin.com');
        $usuario->setUsernameCanonical('admin' . $randomInt);
        $usuario->setEnabled(true);
        $usuario->addRole('ROLE_SUPER_ADMIN');
        
        $em = $this->getDoctrine()->getManager();
        
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($usuario);
        $password = $this->get('security.password_encoder')->encodePassword($usuario, 'admin');
        $usuario->setPassword($password);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        
        return $this->redirectToRoute("homepage", array(
            "nombreEntidad" => "usuario",
            "mensaje" => "Usuario de prueba ".$usuario->getUsername()." guardada con id: " . $usuario->getId()
        ));
    }

    /**
     * @Route("/usuario/prueba", name="prueba_usuario")
     */
    public function createAction()
    {
        $usuario = new Usuario();
        $randomInt = rand();
        $usuario->setCedula($randomInt);
        $usuario->setUsername('test' . $randomInt);
        $usuario->setEmail('test' . $randomInt . '@test.com');
        $usuario->setUsernameCanonical('test');
        $usuario->setEnabled(true);
        
        $em = $this->getDoctrine()->getManager();
        
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($usuario);
        $password = $this->get('security.password_encoder')->encodePassword($usuario, 'test');
        $usuario->setPassword($password);
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        
        return $this->redirectToRoute("listar_entidad", array(
            "nombreEntidad" => "usuario",
            "mensaje" => "Usuario de prueba guardado con id: " . $usuario->getId()
        ));
    }

    /**
     * @Route("usuario/guardar", name="guardar_usuario",
     * requirements={"nombreEntidad" : "usuario"})
     */
    public function guardarUsuarioAction(Request $request)
    {
        // 1) build the form
        $idEntidad = $request->query->get('id');
        if ($idEntidad == null) {
            $operacion = ConstantesDeOperaciones::CREAR;
            $usuario = new Usuario();
            $mensaje = "Usuario creado correctamente";
            $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        } else {
            $operacion = ConstantesDeOperaciones::MODIFICAR;
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('AppBundle:Usuario')->find($idEntidad);
            $passwordViejo = $usuario->getPassword();
            $mensaje = "Usuario modificado correctamente";
            $form = $this->createForm('AppBundle\Form\UsuarioModificarType', $usuario);
        }
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {            
            if ($operacion == ConstantesDeOperaciones::MODIFICAR) {
                $data = $form->getData();
                
                if (strlen($data->getPlainPassword()) == 0) {
                    // if password is not set in modify form keep the old password
                    $usuario->setPassword($passwordViejo);
                } else {
                    // if password is set in modify form then update the password
                    $passwordNuevo = $data->getPlainPassword();
                    $password = $this->get('security.password_encoder')->encodePassword($usuario, $passwordNuevo);
                    $usuario->setPassword($password);
                }
            }
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirectToRoute('listar_entidad', array(
                "nombreEntidad" => 'usuario',
                "mensaje" => $mensaje
            ));
        }
        
        return $this->render('usuario/usuario.html.twig', array(
            'form' => $form->createView(),
            'nombreEntidad' => 'usuario',
            'operacion' => $operacion
        ));
    }
}