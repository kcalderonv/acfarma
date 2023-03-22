<?php
$this->load->view('layouts/header');
?>
<main class="container" id="app">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<div class="cliente">

					</div>

					<div class="producto"></div>


					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<td scope="row">Cod</td>
								<td scope="row">Producto</td>
								<td>Cantidad</td>
								<td>Costo</td>
								<td>Total</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
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
	const app = new Vue({
		el: "#app",
		data() {
			return {

			}
		},
		methods: {

		},
	})
</script>

</html>
