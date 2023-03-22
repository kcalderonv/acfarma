<?php
$this->load->view('layouts/header');
?>
<main class="container" id="app">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="DT" class="table table-sm table-hover">
						<thead>
							<tr>
								<td>Fecha</td>
								<td>Cliente</td>
								<td>Total</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($facturas as $factura) {?>
								<tr>
									<td><?php echo $factura['fecha'] ?></td>
									<td><?php echo $factura['cliente'] ?></td>
									<td><?php echo $factura['total'] ?></td>
								</tr>		
							<?php }?> 
												
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
$this->load->view('layouts/footer');
?>
<script>
var table = new DataTable('#DT', {
	"dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
	buttons: [
		'excel', 'pdf', 'print'
	],
   "responsive": false,
	language: {
        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
    },
});
</script>
