<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cliente extends CI_Controller
{

	public function index()
	{
		$this->load->view('cliente');
	}

	public function select()
	{
		$this->db->order_by('dni');
		$query = $this->db->get('cliente');

		$data = array();
      foreach ($query->result() as $reg) {
			$data[] = array(
				'value' => $reg->id_cliente,
				'text' => $reg->dni.'-'.$reg->nombres
			);
		}
		echo json_encode($data);
	}

	public function listar()
	{
		$query = $this->db->get('cliente');

		$data = array();
      foreach ($query->result() as $reg) {
			$data[] = array(
				'nombres' => $reg->nombres,
				'apellidos' => $reg->apellidos,
				'dni' => $reg->dni,
			);
		}

		echo json_encode($data);
	}

	public function store()
	{
		$json = array('ok' => true, 'msg' => 'cliente guardado exitosamente');

		$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required');
		$this->form_validation->set_rules('dni', 'Dni', 'trim|required');

		if (!$this->form_validation->run()) {
			$json = array('ok' => false, 'msg' => validation_errors('<li>', '</li>'));
			echo json_encode($json);
			exit();
		}

		try {
			$nombres = $this->input->post('nombres');
			$apellidos = $this->input->post('apellidos');
			$dni = $this->input->post('dni');

			$data = array(
				'nombres' =>  $nombres,
				'apellidos' =>  $apellidos,
				'dni' =>  $dni,
			);
			$this->db->insert('cliente', $data);
			echo json_encode($json);
		} catch (Exception $error) {
			$json = array('ok' => false, 'msg' => $error->getMessage());
			echo json_encode($json);
		}
	}
}
