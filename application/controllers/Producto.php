<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Producto extends CI_Controller
{

	public function index()
	{
		$this->load->view('producto');
	}

	public function listar()
	{
		$query = $this->db->get('producto');

		$data = array();
      foreach ($query->result() as $reg) {
			$data[] = array(
				'codigo' => $reg->codigo,
				'descripcion' => $reg->descripcion,
				'precio' => $reg->precio,
			);
		}

		echo json_encode($data);
	}

	public function store()
	{
		$json = array('ok' => true, 'msg' => 'producto guardado exitosamente');

		$this->form_validation->set_rules('codigo', 'Codigo', 'trim|required');
		$this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');
		$this->form_validation->set_rules('precio', 'Precio', 'trim|required|decimal');

		if (!$this->form_validation->run()) {
			$json = array('ok' => false, 'msg' => validation_errors('<li>', '</li>'));
			echo json_encode($json);
			exit();
		}

		try {			
			$codigo = $this->input->post('codigo');
			$descripcion = $this->input->post('descripcion');
			$precio = $this->input->post('precio');

			/* validamos si el codigo ya se encuentra registrado*/
			$this->db->where(array('codigo' => $codigo));  
			$query = $this->db->get('producto');
			if($query->row()){
				$json = array('ok' => false, 'msg' => 'El codigo ya se encuentra registrado');
				echo json_encode($json);
				exit();
			}

			/* registramos */
			$data = array(
				'codigo' =>  $codigo,
				'descripcion' =>  $descripcion,
				'precio' =>  $precio,
			);
			$this->db->insert('producto', $data);
			echo json_encode($json);
		} catch (Exception $error) {
			$json = array('ok' => false, 'msg' => $error->getMessage());
			echo json_encode($json);
		}
	}
}
