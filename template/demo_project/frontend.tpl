<!DOCTYPE html>
<html lang="{$__view.lang_iso2}">
<head>

  <meta charset="utf-8">
  <title>{$__view.title}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
{$__view.meta}

  <script type="text/javascript" src="/lib/jquery-1.9.1.min.js"></script>

  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script type="text/javascript" src="/lib/html5shiv.js"></script>
  <![endif]-->

  <!-- Le styles -->
  <script type="text/javascript" src="/lib/validation/dist/jquery.validate.js"></script>
  <script type="text/javascript" src="/lib/validation/dist/additional-methods.min.js"></script>
  {if $__view.lang_iso2!='en'}
  <script type="text/javascript" src="/lib/validation/localization/messages_{$__view.lang_iso2}.js"></script>
  {/if}

  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="/module/demo/images/favicon.ico" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/module/demo/images/apple-touch-icon-114-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/module/demo/images/apple-touch-icon-72-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" href="/module/demo/images/apple-touch-icon-57-precomposed.png" />
{$__view.links}
{$__view.scripts}
</head>

<body class="area-public">
  <div id="sticky_footer_wrap">

    <header id="header">
      <div class="container">
        <div id="header_container" class="container-fluid">
          {widgets area="header"}
        </div>
      </div>
    </header>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <div id="navbar_container" class="container-fluid">
            <a id="navbar_fixed_top_collapse_button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-align-justify icon-white"></span>
            </a>
            {if $smarty.session.account.id|default:''}
              <a href="/profile/" class="btn btn-navbar">
                <span class="icon-user icon-white"></span>
              </a>
              <a href="/password/" class="btn btn-navbar">
                <span class="icon-heart icon-white"></span>
              </a>
              <a href="/logout/" class="btn btn-navbar">
                <span class="icon-off icon-white"></span>
              </a>
            {else}
              <a class="btn btn-navbar login-modal-button">
                <span class="icon-lock icon-white"></span>
              </a>
            {/if}
            <a class="brand" href="/">{$__config.environment.global.project_name}</a>
            <div class="nav-collapse">
              {widgets area='menu_top'}
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>
    </div>

    <div class="container content-background">
      <div id="content_container" class="container-fluid">
        <div class="row-fluid">
          {widgets area="sidebar_left" assign="sidebar_left"}
          {widgets area="sidebar_right" assign="sidebar_right"}
          {$sidebar_left}
          {if $sidebar_left && $sidebar_right}
            <div class="span6">
          {else}
            {if $sidebar_left || $sidebar_right}
              <div class="span9">
            {else}
              <div class="span12">
            {/if}
          {/if}
            {Alert::fetchAll()}
            {widgets area="above"}
            {$controller_output}
            {widgets area="below"}
            {widgets area="hidden"}
          </div><!--/span-->
          {$sidebar_right}
        </div><!--/row-->
      </div>
    </div><!--/.container-->
    <div id="sticky_footer_push"></div>
  </div>

  <div id="sticky_footer" class="footer">
    <div class="footer-decoration-top"></div>
    <div class="container">
      <div class="muted credit">
        <div class="span3" align="center">
          <h5 class="row">&copy; {$__config.environment.global.company_name} 2012-{'Y'|date}</h5>
        </div>
        <div class="span8" align="center">
          {widgets area="footer"}
        </div>
      </div>
    </div>
    <div class="footer-decoration-bottom"></div>
  </div>

</body>
</html>
