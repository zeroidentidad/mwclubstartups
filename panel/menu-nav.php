	<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="menu">
			<a href="menu.php" class="navbar-brand">
				<img src="./imgs/faviconv.png" width="40" height="40" alt="">
			</a>
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<?php if ($_SESSION["rol"]==1){ ?>
			    <li class="nav-item dropdown <?php if(basename($_SERVER['PHP_SELF'],'.php')=='miperfil'||basename($_SERVER['PHP_SELF'],'.php')=='usuarios'||basename($_SERVER['PHP_SELF'],'.php')=='usuarios_reportes') { ?>active"<?php }else{ ?>"<?php }?> >
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SEGURIDAD</a>
			       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item" href="miperfil.php">Mi perfil</a>
			          <a class="dropdown-item" href="usuarios.php">Usuarios</a>
			          <a class="dropdown-item" href="usuarios_reportes.php">Reportes de usuarios</a>
			       </div>
			    </li>
			    <?php } ?>
			    <?php if ($_SESSION["rol"]==1||$_SESSION["rol"]==2){ ?>
			    <li class="nav-item dropdown <?php if(basename($_SERVER['PHP_SELF'],'.php')=='estados'||basename($_SERVER['PHP_SELF'],'.php')=='registros'||basename($_SERVER['PHP_SELF'],'.php')=='cat_departamentos'||basename($_SERVER['PHP_SELF'],'.php')=='cat_profesiones'||basename($_SERVER['PHP_SELF'],'.php')=='estados_reportes') { ?>active"<?php }else{ ?>"<?php }?> >
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ADMINISTRACION</a>
			       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item" href="estados.php">Estados</a>
			          <a class="dropdown-item" href="registros.php">Registros</a>
			          <a class="dropdown-item" href="cat_departamentos.php">Catalogos</a>
			          <a class="dropdown-item" href="estados_reportes.php">Reportes de estados</a>
			       </div>
			    </li>
			    <?php } ?>
			    <?php if ($_SESSION["rol"]==1||$_SESSION["rol"]==2||$_SESSION["rol"]==3){ ?>
			    <li class="nav-item dropdown <?php if(basename($_SERVER['PHP_SELF'],'.php')=='reportes_consultas'||basename($_SERVER['PHP_SELF'],'.php')=='reportes_masivos'||basename($_SERVER['PHP_SELF'],'.php')=='reportes_individuales') { ?>active"<?php }else{ ?>"<?php }?> >
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">REPORTES</a>
			       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item" href="reportes_consultas.php">Consultas</a>
			          <a class="dropdown-item" href="reportes_masivos.php">Masivos</a>
			          <a class="dropdown-item" href="reportes_individuales.php">Individuales</a>
			       </div>
			    </li>
			    <?php } ?>
			</ul>
		    <form class="form-inline my-2 my-lg-0">		    	
		      <button class="btn btn-outline-info my-2 my-sm-0" type="button" onclick="javascript:location.href='salir.php';">S A L I R</button>
		    </form>			
		</div>
	</nav>