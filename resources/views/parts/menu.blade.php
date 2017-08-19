<ul class="list-group btnModulos">
	<li class="list-group-item">
	<a href="#" class="btn btn-small btn-primary btnModulos">
		Módulos
		<i class="pull-right fa fa-chevron-down btnModulosIcone" aria-hidden="true"></i>
	</a>
		<ul class="ul_submenu">
			<li class="list-group-item retiraMargem">
				<a href="{{ route('home') }}">Dashboard</a>
			</li>
			<li class="list-group-item retiraMargem">
				<a href="{{ route('poupanca') }}">Poupança</a>
			</li>
			<li class="list-group-item retiraMargem">
				<a href="{{ route('listarEntradaSaida') }}">Entradas/Despesas</a>
			</li>
			<!-- <li class="list-group-item retiraMargem">
				<a href="#">Relatórios</a>
			</li> -->
			<li class="list-group-item retiraMargem">
				<a href="{{ route('listarPerfil') }}">Perfil</a>
			</li>
		</ul>
	</li>
</ul>