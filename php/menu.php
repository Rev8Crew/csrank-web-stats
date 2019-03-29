<? 
	$_menu_color = $main ? 'style="color: '.$color.'"' : '';
	$main = $main ? 'class="active"' : '';

	$_menu_color_skins = $display_skins ? 'style="color: '.$color.'"' : '';
	$display_skins = $display_skins ? 'class="active"' : '';
?>

   <nav class="navbar navbar-inverse">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=$website?>">CSRank</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?=$main?>><a href="<?=lang_link("index")?>" <?=$_menu_color?>><?=lang('main')?></a>
                </li>
                <li <?=$display_skins?>><a href="<?=lang_link('display_skins')?>" <?=$_menu_color_skins?>><?=lang('skins')?></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=lang('lang')?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="?lang=ru"><?=lang('ru')?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="?lang=en"><?=lang('en')?></a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form action="search.php" method="get" class="navbar-form navbar-right" role="search">
                <div id="search" class="form-group" style="display: none">
                    <input type="text" name="pid" class="form-control" placeholder="SteamID/IP/Ник">
                </div>
                
                <a  onClick="ShowSearch()"><i id="search_icon" class="fa fa-search" style="color:<?=$color?>; position: absolute; top: 15px; cursor: pointer"></i></a>
            </form>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    
    <!-- /.container-fluid -->
</nav>
