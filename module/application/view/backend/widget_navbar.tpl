<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">{$__config.environment.global.project_name}</a>
    </div>
    <!-- /.navbar-header -->

{if substr($__route.uri, 0, 10)=='/admin/ui/'}

  <ul class="nav navbar-top-links navbar-right">
      <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-messages">
              <li>
                  <a href="#">
                      <div>
                          <strong>John Smith</strong>
                          <span class="pull-right text-muted">
                              <em>Yesterday</em>
                          </span>
                      </div>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <strong>John Smith</strong>
                          <span class="pull-right text-muted">
                              <em>Yesterday</em>
                          </span>
                      </div>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <strong>John Smith</strong>
                          <span class="pull-right text-muted">
                              <em>Yesterday</em>
                          </span>
                      </div>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>Read All Messages</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
          </ul>
          <!-- /.dropdown-messages -->
      </li>
      <!-- /.dropdown -->
      <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-tasks">
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 1</strong>
                              <span class="pull-right text-muted">40% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                  <span class="sr-only">40% Complete (success)</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 2</strong>
                              <span class="pull-right text-muted">20% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                  <span class="sr-only">20% Complete</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 3</strong>
                              <span class="pull-right text-muted">60% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                  <span class="sr-only">60% Complete (warning)</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Task 4</strong>
                              <span class="pull-right text-muted">80% Complete</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                  <span class="sr-only">80% Complete (danger)</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>See All Tasks</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
          </ul>
          <!-- /.dropdown-tasks -->
      </li>
      <!-- /.dropdown -->
      <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-alerts">
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-comment fa-fw"></i> New Comment
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                          <span class="pull-right text-muted small">12 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-envelope fa-fw"></i> Message Sent
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-tasks fa-fw"></i> New Task
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-upload fa-fw"></i> Server Rebooted
                          <span class="pull-right text-muted small">4 minutes ago</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>See All Alerts</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
          </ul>
          <!-- /.dropdown-alerts -->
      </li>
      <!-- /.dropdown -->
      <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
              <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
              </li>
              <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
              </li>
              <li class="divider"></li>
              <li><a href="/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
              </li>
          </ul>
          <!-- /.dropdown-user -->
      </li>
      <!-- /.dropdown -->
  </ul>
  <!-- /.navbar-top-links -->

{else}

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
          <a href="#email-message" onclick="return jQuery.joodeeAccountManager.emailMessage('/admin/sendmail/');">
            <i class="fa fa-envelope fa-fw"></i>
          </a>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>
                {if empty($account.nickname)}{if empty($account.first_name)}{$account.email|escape}{else}{$account.first_name|escape} {$account.last_name|escape}{/if}{else}{$account.nickname}{/if}
                <i class="fa fa-caret-down fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li class="nav-account-profile"><a href="/profile/"><i class="fa fa-user fa-fw"></i> Edit Profile</a></li>
                <li class="nav-account-password"><a href="/password/"><i class="glyphicon glyphicon-lock fa-fw"></i> Change Password</a></li>
                <li class="divider"></li>
                <li class="nav-account-logout"><a href="/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
{/if}

    <div class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    </div>
                    <!-- /input-group -->
                </li>

                <li{if $__route.uri=='/admin/'} class="active"{/if}><a href="/admin/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                <li{if $__route.uri=='/admin/accounts/'} class="active"{/if}><a href="/admin/accounts/"><i class="fa fa-users fa-fw"></i> Account Manager</a></li>
                <li{if substr($__route.uri, 0, 10)=='/admin/ui/'} class="active"{/if}>
                  <a href="#"><i class="glyphicon glyphicon-eye-close fa-fw"></i> UI Examples <span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                    <li{if $__route.uri=='/admin/ui/'} class="active"{/if}>
                      <a href="/admin/ui/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li{if substr($__route.uri, 0, 17)=='/admin/ui/charts-'} class="active"{/if}>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="/admin/ui/charts-flot/">Flot Charts</a>
                            </li>
                            <li>
                                <a href="/admin/ui/charts-morris/">Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                    <li>
                        <a href="/admin/ui/tables/"><i class="fa fa-table fa-fw"></i> Tables</a>
                    </li>
                    <li>
                        <a href="/admin/ui/forms/"><i class="fa fa-edit fa-fw"></i> Forms</a>
                    </li>
                    <li{if substr($__route.uri, 0, 19)=='/admin/ui/elements-'} class="active"{/if}>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="/admin/ui/elements-panels-wells/">Panels and Wells</a>
                            </li>
                            <li>
                                <a href="/admin/ui/elements-buttons/">Buttons</a>
                            </li>
                            <li>
                                <a href="/admin/ui/elements-notifications/">Notifications</a>
                            </li>
                            <li>
                                <a href="/admin/ui/elements-typography/">Typography</a>
                            </li>
                            <li>
                                <a href="/admin/ui/elements-grid/">Grid</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                    <li{if substr($__route.uri, 0, 15)=='/admin/ui/page-'} class="active"{/if}>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="/admin/ui/page-blank/">Blank Page</a>
                            </li>
                            <li>
                                <a href="/admin/ui/page-login/">Login Page</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                  </ul>
                </li>


            </ul>
            <!-- /#side-menu -->
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
