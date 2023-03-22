<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Factura extends CI_Controller
{

	public function index()
	{
		$this->db->select('cliente.nombres, cliente.apellidos, factura.fecha, factura.total');
		$this->db->from('factura');
		$this->db->join('cliente', 'cliente.id_cliente = factura.cliente_id');
		$query = $this->db->get();

		$data = array();
      foreach ($query->result() as $reg) {
			$data[] = array(
				'cliente' => $reg->nombres.' '.$reg->apellidos,
				'fecha' => $reg->fecha,
				'total' => $reg->total,
			);
		}

		$this->load->view('factura', ['facturas' => $data]);
	}

	public function store()
	{
		$json = array('ok' => true, 'msg' => 'factura guardado exitosamente');

		try {
			$cliente = $this->input->post('cliente');
			$total = $this->input->post('total');
			$detalle = json_decode($this->input->post('detalle'));
			$observacion = $this->input->post('observaciones');
			/* crear cabecera factura */
			$data = array(
				'cliente_id' => $cliente,
				'total' => $total,
				'observacion' => $observacion??'',
				'fecha' => date('Y-m-d')
			);
			
			$this->db->insert('factura', $data);
			$factura_id = $this->db->insert_id(); 

			/* crear detalle de la factura */
			foreach ($detalle as $producto) {
				$data = array(
					'id_factura' =>  $factura_id,
					'id_producto' =>  $producto->producto_id,
					'costo_unitario' =>  $producto->precio,
					'cantidad' =>  $producto->cantidad,
					'total' =>  $producto->total,
				);
				$this->db->insert('factura_detalle', $data);
			}
			
			echo json_encode($json);
		} catch (Exception $error) {
			$json = array('ok' => false, 'msg' => $error->getMessage());
			echo json_encode($json);
		}
	}
}
