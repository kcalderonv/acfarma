<?php
$this->load->view('layouts/header');
?>
<main class="container" id="app">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="form my-2">
						<form @submit.prevent="submit">
							<div class="row">
								<div class="col-12 col-md-2">
									<div class="form-group">
										<label for="nombres">Codigo <span class="text-danger">*</span></label>
										<input type="text" maxlength="50" minlength="3" class="form-control" id="codigos" placeholder="Ingresar Codigo" required v-model="form.codigo">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="descripcion">Descripción <span class="text-danger">*</span></label>
										<input type="text" maxlength="50" minlength="3" class="form-control" id="descripcion"  placeholder="Ingresar producto" required v-model="form.descripcion">
									</div>
								</div>
								<div class="col-12 col-md-2">
									<div class="form-group">
										<label for="dni">Precio <span class="text-danger">*</span></label>
										<input type="text" pattern="^\d*(\.\d{0,2})?$" maxlength="10" minlength="3" class="form-control" id="precio" placeholder="10.00" required v-model="form.precio">
									</div>
								</div>
								<div class="col-12 col-md-2">
									<button type="submit" class="btn btn-primary mt-4">Guardar</button>
								</div>
							</div>
						</form>
					</div>
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<td>Codigo</td>
								<td>Descripción</td>
								<td>Ppecio</td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(producto, index) in productos">
								<td v-text="producto.codigo"></td>
								<td v-text="producto.descripcion"></td>
								<td v-text="producto.precio"></td>
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
				productos:[],
				form:{
					codigo: '',
					descripcion: '',
					precio: '',
				}
			}
		},
		methods: {
			init(){
				this.listar();
			},
			limpiar(){
				this.form = {
					codigo: '',
					descripcion: '',
					precio: '',
				}
			},
			async listar(){
				const {data} = await axios.get('/producto/listar');
				this.productos = data;
			},
			async submit(){
				try {
					let formData = new FormData();
					formData.append('codigo', this.form.codigo);
					formData.append('descripcion', this.form.descripcion);
					formData.append('precio', this.form.precio);

					const { data } = await axios.post('/producto/store', formData)
					alert(data.msg);
					if(data.ok){						
						this.listar();
						this.limpiar();
					}
				} catch (error) {
					console.log(error)
					alert("Se produjo un error, intente mas tarde");
				}
			}
		},
		created() {
			this.init();
		},
	})
</script>

</html>
