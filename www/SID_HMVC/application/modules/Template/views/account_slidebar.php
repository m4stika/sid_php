<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/pages/scripts/handle-treeaccount.js" type="text/javascript"></script>

			<a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                <div class="page-quick-sidebar">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Account
                                <!-- <span class="badge badge-danger">2</span> -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Search
                                <!-- <span class="badge badge-success">7</span> -->
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab"> Custom
                                <!-- <span class="badge badge-success">7</span> -->
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- <div class="margin-bottom-20"></div> -->
                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                            <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                <!-- <h3 class="list-heading">Staff</h3> -->
                                    <div class="page-quick-sidebar-chat-user-form">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Type a searching here..." type="text" id="searchitem">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn green">
                                                    <i class="icon-magnifier"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-quick-sidebar-chat-user-messages">
                                        <div id="tree_acc" class="margin-top-10 tree-demo"> 
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2"> -->
                        <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                            <!-- <div class="margin-top-20"></div> -->
                            <div class="page-quick-sidebar-search-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type a searching here..." type="text" id="searchaccount">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn green" id="accountbtn">
                                            <i class="icon-magnifier"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="page-quick-sidebar-alerts-list">
                            <!-- <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list"> -->
                                <ul class="feeds list-items"> </ul>
                            </div>
                        </div>
                        <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_3">
                            <!-- <div class="margin-top-20"></div> -->
                            <div class="page-quick-sidebar-search-form">
                                <div class="form-group">    
                                    <select class="form-control selectpicker" data-style="btn-success" name="source" id="source">
                                        <option value="0">select...</option>
                                        <option value="1">Kontrak</option>
                                        <option value="2">Kwitansi</option>
                                        <option value="3">Journal</option>
                                        <option value="4">Inventory</option>
                                        <option value="5">Kas-Bank</option>
                                        <option value="6">Perkiraan Kas-Bank</option>
                                        <option value="7">Perkiraan All</option>
                                        <option value="8">Fixed Asset</option>
                                        <option value="9">Pembatalan Konsumen</option>
                                    </select>
                                </div>
                                <div class="input-group margin-top-10">
                                    <input type="text" class="form-control" placeholder="Type a searching here..." id="searchcustom">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn green" id="searchbtn">
                                            <i class="icon-magnifier"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="page-quick-sidebar-alerts-list">
                                <ul class="feeds list-custom"> </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- </div> -->