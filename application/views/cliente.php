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
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="nombres">Nombres <span class="text-danger">*</span></label>
										<input type="text" maxlength="50" minlength="3" class="form-control" id="nombres"  placeholder="Ingresar Nombres" required v-model="form.nombres">
									</div>
								</div>
								<div class="col-12 col-md-3">
									<div class="form-group">
										<label for="apellidos">Apellidos <span class="text-danger">*</span></label>
										<input type="text" maxlength="50" minlength="3" class="form-control" id="apellidos"  placeholder="Ingresar Apellidos" required v-model="form.apellidos">
									</div>
								</div>
								<div class="col-12 col-md-3">
									<div class="form-group">
										<label for="dni">DNI <span class="text-danger">*</span></label>
										<input type="text" maxlength="8" minlength="8" class="form-control" id="dni"  placeholder="Ingresar DNI" required v-model="form.dni">
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
								<td>DNI</td>
								<td>Nombres</td>
								<td>Apellido</td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(cliente, index) in clientes">
								<td v-text="cliente.dni"></td>
								<td v-text="cliente.nombres"></td>
								<td v-text="cliente.apellidos"></td>
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
				clientes:[],
				form:{
					nombres: '',
					apellidos: '',
					dni: '',
				}
			}
		},
		methods: {
			init(){
				this.listar();
			},
			limpiar(){
				this.form = {
					nombres: '',
					apellidos: '',
					dni: '',
				}
			},
			async listar(){
				const {data} = await axios.get('/cliente/listar');
				console.log(data)
				this.clientes = data;
			},
			async submit(){
				try {
					let formData = new FormData();
					formData.append('nombres', this.form.nombres);
					formData.append('apellidos', this.form.apellidos);
					formData.append('dni', this.form.dni);

					const { data } = await axios.post('/cliente/store', formData)
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
