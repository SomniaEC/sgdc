<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="centroEducativo")
 */
class CentroEducativo extends EntidadBase {
	
	/**
	 * @ORM\Column(type="string", length=13, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Ruc debe contener numeros solamente"
     * )
     * @Assert\Length(
     *      min = 13,
     *      max = 13,
     *      exactMessage = "Ruc debe tener {{ limit }} digitos"
     * )
	 */
	private $identificacion;
	
	/**
	 * @ORM\Column(type="string", length=250, nullable=true)
	 */
	private $nombre;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Telefono debe contener numeros solamente"
     * ) 
	 */
	private $telefono;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Junta", cascade={"persist"})
	 * @ORM\JoinColumn(name="junta_id", referencedColumnName="id")
	 */
	private $junta;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Direccion", cascade={"persist"})
	 * @ORM\JoinColumn(name="direccion_id", referencedColumnName="id")
	 */
	private $direccion;
	
	/**
	 *
	 * {@inheritdoc}
	 * @see \AppBundle\Entity\EntidadBase::getMostrarDetalles()
	 */
	public function getMostrarDetalles() {
		return array (
				$this->id,
				$this->identificacion,
				$this->nombre,
				$this->telefono
		);
	}
	
	/**
	 *
	 * @return string[]
	 */
	public static function getMostrarCabeceras() {
		return array (
				"id",
				"identificacion",
				"nombre",
				"telefono" 
		);
	}
	
	/**
	 *
	 * @return string
	 */
	public static function getNombreEntidad() {
		return "centroEducativo";
	}
	
	/**
	 *
	 * {@inheritdoc}
	 * @see \AppBundle\Entity\EntidadBase::__toString()
	 */
	public function __toString() {
		return $this->nombre == null ? "" : $this->nombre;
	}
	/**
	 * @return mixed
	 */
	public function getIdentificacion() {
		return $this->identificacion;
	}

	/**
	 * @param mixed $identificacion
	 */
	public function setIdentificacion($identificacion) {
		$this->identificacion = $identificacion;
	}

	/**
	 * @return mixed
	 */
	public function getNombre() {
		return $this->nombre;
	}

	/**
	 * @param mixed $nombre
	 */
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	/**
	 * @return mixed
	 */
	public function getTelefono() {
		return $this->telefono;
	}

	/**
	 * @param mixed $telefono
	 */
	public function setTelefono($telefono) {
		$this->telefono = $telefono;
	}

	/**
	 * @return mixed
	 */
	public function getJunta() {
		return $this->junta;
	}

	/**
	 * @param mixed $junta
	 */
	public function setJunta($junta) {
		$this->junta = $junta;
	}

	/**
	 * @return mixed
	 */
	public function getDireccion() {
		return $this->direccion;
	}

	/**
	 * @param mixed $direccion
	 */
	public function setDireccion($direccion) {
		$this->direccion = $direccion;
	}

}
