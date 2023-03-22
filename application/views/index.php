<?php
$this->load->view('layouts/header');
?>
<main class="container" id="app">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="cliente">
						<div class="row">
							<div class="col-12 col-md-10">
								<div class="form-group">
									<label for="cliente">Cliente</label>
									<select id="cliente" class="form-control" name="cliente" v-model="form.cliente">
										<option v-for="(cliente,index) in clientes" :key="index" :value="cliente.value" v-text="cliente.text"></option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-2">
								<a href="/cliente" class="btn btn-outline-info mt-4">Crear</a>
							</div>
						</div>
					</div>
					<div class="producto">
						<div class="row">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label for="cliente">Producto</label>
									<select v-model="producto.producto" id="producto" class="form-control" name="producto">
										<option v-for="(producto,index) in productos" :key="index" :value="producto" v-text="producto.text"></option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-3">
								<div class="form-group">
									<label for="cantidad">Cantidad <span class="text-danger">*</span></label>
									<input v-model="producto.cantidad" type="text" class="form-control" id="cantidad" placeholder="Ingresar Nombres" required v-model="producto.cantidad">
								</div>
							</div>
							<div class="col-12 col-md-2">
								<div class="form-group">
									<label for="cantidad">Importe <span class="text-danger">*</span></label>
									<h5 v-text="importe"></h5>
								</div>
							</div>
							<div class="col-12 col-md-2">
								<button @click="agregar" href="/cliente" class="btn btn-info mt-4">agregar</button>
							</div>
						</div>
					</div>
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<td>Cod</td>
								<td>Producto</td>
								<td>Cantidad</td>
								<td>Costo</td>
								<td>Total</td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item, index) in form.detalle" :key="index">
								<td v-text="item.cod"></td>
								<td v-text="item.producto"></td>
								<td v-text="item.cantidad"></td>
								<td v-text="item.precio"></td>
								<td v-text="item.total"></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group">
					  <label for="observaciones">Observaciones</label>
					  <textarea v-model="form.observaciones" class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
					</div>
					<hr>
					<div class="my-3">
						<button @click="submit" class="btn btn-primary">Generar Factura S/<span v-text="importeTotal"></span></button>
					</div>
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
				clientes: [],
				productos: [],
				producto: {
					producto: '',
					cantidad: 1,
				},
				form: {
					cliente: '',
					detalle: [],
					observaciones: '',
				}
			}
		},
		computed: {
			importe(){
				if(this.producto.producto){
					return 'S/ '+ (this.producto.cantidad * this.producto.producto.precio);
				}
				return ''; 
			},
			importeTotal(){
				if(this.form.detalle){
					let total = 0;
					this.form.detalle.forEach(item => {
						 total += item.total;
					}); 
					return total;
				}
				return '0.00';
			}
		},
		methods: {
			async init(){
				let resp = '';
				resp = await axios.get('/cliente/select');
				this.clientes = resp.data;

				resp = await axios.get('/producto/select');
				this.productos = resp.data;
			},
			async agregar() {				
				if(!this.producto.producto || !this.producto.cantidad){
					return alert('Debe seleccionar el producto e ingresar la cantidad');
				}
				const producto = this.producto.producto;

				/* validad si ya se agrego el producto */
				let valida = this.form.detalle.find(item => item.cod === producto.codigo);
				if(valida){
					return alert('Producyto ya agregado');
				}

				/* agregar el producto */
				let data = {
					cod: producto.codigo,
					producto: producto.descripcion,
					producto_id: producto.value,
					precio: producto.precio,
					cantidad: this.producto.cantidad,
					total: (this.producto.cantidad * producto.precio)
				};
				this.producto.producto = '';
				this.producto.cantidad = 1;
				this.form.detalle.push(data);
			},
			limpiar(){
				this.form = {
					cliente: '',
					detalle: [],
					observaciones: '',
				};
			},
			async submit() {
				try {
					let formData = new FormData();
					formData.append('cliente', this.form.cliente);
					formData.append('total', this.importeTotal);
					formData.append('observaciones', this.observaciones);
					formData.append('detalle', JSON.stringify(this.form.detalle));

					const { data } = await axios.post('/factura/store', formData)
					alert(data.msg);
					if(data.ok){			
						this.limpiar();
					}
				} catch (error) {
					console.log(error)
					alert("Se produjo un error, intente mas tarde");
				}
			},
		},
		created() {
			this.init();
		},
	})
</script>

</html>
