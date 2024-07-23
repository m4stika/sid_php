var TableDatatablesEditable = function () {

    var handleTableDoc = function () {
        // function createCellPos( n ){
        //     var ordA = 'A'.charCodeAt(0);
        //     var ordZ = 'Z'.charCodeAt(0);
        //     var len = ordZ - ordA + 1;
        //     var s = "";
         
        //     while( n >= 0 ) {
        //         s = String.fromCharCode(n % len + ordA) + s;
        //         n = Math.floor(n / len) - 1;
        //     }
            
        //     return s;
        // }

        var wrapper = $('#wrapper');
        var wrapperDoc = wrapper.find('#row_masterdoc');
        
        var table = wrapperDoc.find('#datatable_doc');
        var wrapperDocform = $('#form_edit');
        var formDoc = wrapperDocform.find('#form_edit_body');
        var formDelete = $('#form_delete');
        var grid = new Datatable();
        
        grid.init({
            src: table,
            dataTable: {
                "processing": true,
                "lengthMenu": [
                    [5,10, 20, 50, 100, 150, -1],
                    [5,10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "columns": [
                    { "data": "action",  "orderable": false, "searchable": false, render: function ( data, type, row, meta ) {
                            var dropdown = new gridDropdown();
                            return dropdown.addDropdown(data);
                        }
                    },
                    { "data": "noid", "title": "#ID"},
                    { "data": "namadokumen", "title": "#Nama"},
                    { "data": "dokumenumum", "title": "Umum",  "orderable": false, "searchable": false,
                        render: function ( data, type, row, meta ) {
                            return (data == '1') ? "<span class=\"fa fa-check\"></span>" : "";
                        }
                    },
                    { "data": "dokumenpegawai", "title": "Pegawai",  "orderable": false, "searchable": false,
                        render: function ( data, type, row, meta ) {
                            return (data == '1') ? "<span class=\"fa fa-check\"></span>" : "";
                        }
                    },
                    { "data": "dokumenprofesional", "title": "Profesional",  "orderable": false, "searchable": false,
                        render: function ( data, type, row, meta ) {
                            return (data == '1') ? "<span class=\"fa fa-check\"></span>" : "";
                        }
                    },
                    { "data": "dokumenwiraswasta", "title": "Wiraswasta",  "orderable": false, "searchable": false,
                        render: function ( data, type, row, meta ) {
                            return (data == '1') ? "<span class=\"fa fa-check\"></span>" : "";
                        }
                    },
                ],
                "ajax": {
                    type: "post",
                    dataType: "json",
					url: siteurl+"Pemasaran/masterdokumen/get_list", // ajax source
                    data: { flag: 1},
					error: function (xhr, error, thrown) {
                                App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: grid.gettableContainer(),
                                    place: 'prepend',
                                   // closeInSeconds: 3 // auto close in 5 seconds
                                });
                                App.unblockUI(wrapperDoc.find('.table-container'));
							}
                },
                // buttons: [
                //     {
                //         extend: 'excelHtml5',
                //         text: 'Save as Excel',
                //         customize: function( xlsx ) {
                //             console.log('customize');
                //             var sheet = xlsx.xl.worksheets['sheet1.xml'];
                //             var lastCol = sheet.getElementsByTagName('col').length - 1;
                //             var colRange = createCellPos( lastCol ) + '1';
                //             //Has to be done this way to avoid creation of unwanted namespace atributes.
                //             var afSerializer = new XMLSerializer();
                //             var xmlString = afSerializer.serializeToString(sheet);
                //             var parser = new DOMParser();
                //             var xmlDoc = parser.parseFromString(xmlString,'text/xml');
                //             var xlsxFilter = xmlDoc.createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','autoFilter');
                //             var filterAttr = xmlDoc.createAttribute('ref');
                //             filterAttr.value = 'A1:' + colRange;
                //             xlsxFilter.setAttributeNode(filterAttr);
                //             sheet.getElementsByTagName('worksheet')[0].appendChild(xlsxFilter);
                //         }
                //     }
                // ],
				buttons: [
                    { extend: 'print', className: 'btn default', exportOptions: { columns: [1,2,3,4,5,6] } },
                    { extend: 'copy', className: 'btn default', exportOptions: { columns: [1,2,3,4,5,6] } },
                    { extend: 'pdf', className: 'btn default', exportOptions: { columns: [1,2,3,4,5,6] } },
                    { extend: 'excelHtml5', className: 'btn default', exportOptions: { columns: [1,2,3,4,5,6] },
                        text: 'Save as Excel',
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr( 's', '42' );
                        }
                     },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                        }
                    }
                ],
                "order": [
                    [1, "asc"]
                ]// set first column as a default sort by asc
            }
        });
        var oTable = grid.getDataTable();

        // handle datatable custom tools
        wrapperDoc.find('.actions > .btn-group > ul > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.button(action).trigger();
        });

        //MasterDocument Validate
        formDoc.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
                rules: {
                    namadokumen: {
                        required: true
                    },
                },
                messages:
                {
                    namadokumen:{
                          required: "Nama Dokumen harus diisi"
                            }
                },
                highlight: function(element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function(label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },

                 submitHandler: function(e){
                    var data = formDoc.serialize();
                    $.ajax({
                            type: 'post',
                            dataType: 'json',
                            url: siteurl+'Pemasaran/masterdokumen/set_crud', // ajax source
                            data: data,
                            error: function (xhr, error, thrown) {
                                        $('.m-heading-1 > p').html(xhr.responseText);
                                    }
                        }).success(function(response) {
                            console.log(response);
                            });
                    oTable.ajax.reload();
                    $('.bxmasterdoc').modal("hide");
                    return false;
                }
        });

        //reload button click
        wrapperDoc.on('click','.reload',function (e) {
            oTable.ajax.reload();
        });

        //new button click
        wrapperDoc.on('click','.new',function (e) {
            //var nRow = $(this).parents('tr')[0];
            //var aData =  oTable.fnGetData(nRow);
            formDoc.trigger('reset');
            formDoc.find('[name="status"]').val('new').end();
            wrapperDocform.find('.portlet-title span.caption-helper').text("New Data");
            //validasidoc();
            e.preventDefault();
            //handleModalReposition();
            bootbox
                        .dialog({
                            size: 'medium',
                            //title: 'New Master Dokumen',
                            message: wrapperDocform,
                            className: "bxmasterdoc",
                            show: false // We will show it manually later
                        })
                        .on('shown.bs.modal', function() {
                            wrapperDocform.show();
                        })
                        .on('hide.bs.modal', function(e) {
                            wrapperDocform.hide().appendTo('body');
                        })
                        .modal('show');

        });

        //Edit & copy
        wrapperDoc.on('click', '.edit, .copy', function(e) {
            var aData = oTable.row('.selected').data();
            if (aData === undefined) {
                var rowindex = (this).closest('tr').rowIndex;
                aData = oTable.row(rowindex-2).data();
            }
            handleCopyEdit(e,aData.noid);
        });

        var handleCopyEdit = function(e, noid) {
            var status = '';
            
            e.preventDefault();
            
            if ($(e.target).hasClass('edit')||$(e.target).parent().hasClass('edit')) { 
                //form.find('#crud').val("edit");
                //wrapperDocform.find('.page-title').html("perencanaan <small>Edit Type Rumah</small>");
                wrapperDocform.find('.portlet-title span.caption-helper').text("Koreksi Data");
                status = 'edit';
            } else {
                //form.find('#crud').val("copy");
                //wrapperDocform.find('.page-title').html("perencanaan <small>Copy Type Rumah</small>");
                wrapperDocform.find('.portlet-title span.caption-helper').text("Duplicate Data");
                status = 'copy';
            }

            formDoc.trigger('reset');
            //formDoc.validate();
            
            $.ajax({
                    type: "post",
                    dataType: "json",
                    url: siteurl+"Pemasaran/masterdokumen/get_record", // ajax source
                    data : {
                        noid: noid,
                    },
                    error: function (xhr, error, thrown) {
                                App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: grid.gettableContainer(),
                                    place: 'prepend',
                                    closeInSeconds: 3 // auto close in 5 seconds
                                });
                            }
                }).success(function(response) {
                    formDoc
                    .find('[name="status"]').val(status).end()
                    .find('[name="noid"]').val(status == 'edit' ? response.data.noid : -1).end()
                    .find('[name="namadokumen"]').val(response.data.namadokumen).end()
                    .find('[id="umum"]').prop('checked',((response.data.dokumenumum==1) ? true : false)).end()
                    .find('[id="pegawai"]').prop('checked',((response.data.dokumenpegawai==1) ? true : false)).end()
                    .find('[id="profesional"]').prop('checked',((response.data.dokumenprofesional==1) ? true : false)).end()
                    .find('[id="wiraswasta"]').prop('checked',((response.data.dokumenwiraswasta==1) ? true : false)).end();

                    if (response.hasil == "OK") {
                        //handleModalReposition();
                        bootbox
                            .dialog({
                                //title: 'Edit Master Dokumen',
                                message: wrapperDocform,
                                className: "bxmasterdoc",
                                size: "medium",
                                show: false // We will show it manually later
                            })
                            .on('shown.bs.modal', function() {
                                wrapperDocform.show();
                            })
                            .on('hide.bs.modal', function(e) {
                                wrapperDocform.hide().appendTo('body');
                            })
                            .modal('show');
                    } else console.log('No Record to display');
                });
            //return output;
        };

        //Delete
        wrapperDoc.on('click', '.delete', function(e) {
            var aData = oTable.row('.selected').data();
            if (aData === undefined) {
                var rowindex = (this).closest('tr').rowIndex;
                aData = oTable.row(rowindex-2).data();
            }
            var originalState = formDelete.clone();
            e.preventDefault();
            //handleModalReposition();
            formDelete
                .find('[id="noid"]').html( "<strong>"+aData.noid+"</strong>" ).end()
                .find('[id="namadoc"]').html( "<strong>"+aData.namadokumen+"</strong>" ).end();

                bootbox
                    .confirm( {
                    size: 'medium',
                    closeButton: false,
                    //title: 'SID - Delete Record',
                    message: formDelete,
                    buttons: {
                        'cancel': {
                            label: 'Cancel',
                            className: 'btn-default'
                        },
                        'confirm': {
                            label: 'Delete',
                            className: 'btn-danger'
                        }
                    },

                    callback: function(result) {
                        if(result) {
                            $.ajax({
                            type: "post",
                            dataType: "json",
                            url: siteurl+"Pemasaran/masterdokumen/set_delete", // ajax source
                            data: { noid: aData.noid },
                            error: function (xhr, error, thrown) {
                                    App.alert({
                                        type: 'danger',
                                        icon: 'warning',
                                        message: xhr.responseText,
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                       // closeInSeconds: 3 // auto close in 5 seconds
                                    });
                                    },
                            success: function(result) {
                                    App.alert({
                                        type: 'success',
                                        icon: 'info',
                                        message: "Record has been deleted..",
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                        closeInSeconds: 3 // auto close in 5 seconds
                                    });
                                    oTable.ajax.reload();
                                }
                            });
                        }else {
                            App.alert({
                                        type: 'success',
                                        icon: 'info',
                                        message: "Record delete canceled..",
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                        closeInSeconds: 3 // auto close in 5 seconds
                                    });
                        }
                    }
                })
                .on('shown.bs.modal', function() {
                            formDelete.show();
                })

                .on('hide.bs.modal', function(e) {
                            formDelete.replaceWith(originalState.clone());
                            formDelete.hide().appendTo('body');
                });
        });
    };



    var handleTableProgresKPR = function () {
        var wrapper = $('#wrapper');
        var wrapperProgress = wrapper.find('#row_masterprogress');
        var table = wrapperProgress.find('#datatable_progress');
        var wrapperform = $('#form_edit_Progres');
        var form = wrapperform.find('#form_edit_Progres_body');
        var formDelete = $('#form_delete');
        var grid = new Datatable();

        grid.init({
            src: table,
            dataTable: {
                "processing": true,
                "lengthMenu": [
                    [5,10, 20, 50, 100, 150, -1],
                    [5,10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "columns": [
                    { "data": "action", "title": "Actions",  "orderable": false, "searchable": false, render: function ( data, type, row, meta ) {
                            var dropdown = new gridDropdown();
                            return dropdown.addDropdown(data);
                        }
                    },
                    { "data": "noid", "title": "#ID"},
                    { "data": "namaprogres", "title": "#Nama"}
                ],
                "ajax": {
                    type: "post",
                    dataType: "json",
                    url: siteurl+"Pemasaran/masterprogres/get_list", // ajax source
                    data: { flag: 2
                            },
                    error: function (xhr, error, thrown) {
                                console.log(xhr);
                                $('.m-heading-1 > p').html(xhr.responseText);
                            }
                },
                buttons: [
                    { extend: 'print', className: 'btn default', exportOptions: { columns: [1,2] } },
                    { extend: 'copy', className: 'btn default', exportOptions: { columns: [1,2] } },
                    { extend: 'pdf', className: 'btn default', exportOptions: { columns: [1,2] } },
                    { extend: 'excelHtml5', className: 'btn default', exportOptions: { columns: [1,2] },
                        text: 'Save as Excel',
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr( 's', '42' );
                        }
                     },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                        }
                    }
                ],
                "order": [
                    [1, "asc"]
                ]
            }
        });
        oTable = grid.getDataTable();

        // handle datatable custom tools
        wrapperProgress.find('.actions > .btn-group > ul > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.button(action).trigger();
        });

        //Progress Validation
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
                rules: {
                    namaprogres: {
                        required: true
                    },
                },
                messages:
                {
                    namaprogres:{
                          required: "Keterangan Progress harus diisi"
                            }
                },
                highlight: function(element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function(label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },

                submitHandler: function(e){
                    var data = form.serialize();                
                    $.ajax({
                            type: 'post',
                            dataType: 'json',
                            url: siteurl+'Pemasaran/masterprogres/set_crud', // ajax source
                            data: data,
                            error: function (xhr, error, thrown) {
                                        $('.m-heading-1 > p').html(xhr.responseText);
                                    }
                        }).success(function(response) {
                            console.log(response);
                            });
                    oTable.ajax.reload();
                    $('.bxmasterprogres').modal("hide");
                    return false;
                }
        });

        //reload button click
        wrapperProgress.on('click','.reload',function (e) {
            oTable.ajax.reload();
        });

        //new button click
        wrapperProgress.on('click','.new',function (e) {
            e.preventDefault();
            form.trigger('reset');
            form.find('[name="status"]').val('new').end();
            wrapperform.find('.portlet-title span.caption-helper').text("New Data");
            //handleModalReposition();
            bootbox
                .dialog({
                    size: 'medium',
                    //title: 'New Master Progress',
                    message: wrapperform,
                    className: "bxmasterprogres",
                    show: false // We will show it manually later
                })
                .on('shown.bs.modal', function() {
                    wrapperform.show();
                })
                .on('hide.bs.modal', function(e) {
                    wrapperform.hide().appendTo('body');
                })
                .modal('show');

        });

        //Edit & copy
        wrapperProgress.on('click', '.edit, .copy', function(e) {
            var aData = oTable.row('.selected').data();
            if (aData === undefined) {
                var rowindex = (this).closest('tr').rowIndex;
                aData = oTable.row(rowindex-2).data();
            }
            handleCopyEdit(e,aData.noid);
        });

        var handleCopyEdit = function(e, noid) {
            var status = '';
            
            e.preventDefault();
            
            if ($(e.target).hasClass('edit')||$(e.target).parent().hasClass('edit')) { 
                wrapperform.find('.portlet-title span.caption-helper').text("Koreksi Data");
                status = 'edit';
            } else {
                wrapperform.find('.portlet-title span.caption-helper').text("Duplicate Data");
                status = 'copy';
            }

            form.trigger('reset');
            $.ajax({
                    type: "post",
                    dataType: "json",
                    url: siteurl+"Pemasaran/masterprogres/get_record", // ajax source
                    data : {
                        noid: noid,
                    },
                    error: function (xhr, error, thrown) {
                                App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: grid.gettableContainer(),
                                    place: 'prepend',
                                    closeInSeconds: 3 // auto close in 5 seconds
                                });
                            }
                }).success(function(response) {
                    form
                    .find('[name="status"]').val(status).end()
                    .find('[name="noid"]').val(status == 'edit' ? response.data.noid : -1).end()
                    .find('[name="namaprogres"]').val(response.data.namaprogres).end();

                    if (response.hasil == "OK") {
                        //handleModalReposition();
                        bootbox
                            .dialog({
                                message: wrapperform,
                                className: "bxmasterprogres",
                                size: "medium",
                                show: false // We will show it manually later
                            })
                            .on('shown.bs.modal', function() {
                                wrapperform.show();
                            })
                            .on('hide.bs.modal', function(e) {
                                wrapperform.hide().appendTo('body');
                            })
                            .modal('show');
                    } else console.log('No Record to display');
                });
            //return output;
        };

        //Delete
        wrapperProgress.on('click', '.delete', function(e) {
            var aData = oTable.row('.selected').data();
            if (aData === undefined) {
                var rowindex = (this).closest('tr').rowIndex;
                aData = oTable.row(rowindex-2).data();
            }
            var originalState = formDelete.clone();
            e.preventDefault();
            //handleModalReposition();
            formDelete
                .find('[id="noid"]').html( "<strong>"+aData.noid+"</strong>" ).end()
                .find('[id="namadoc"]').html( "<strong>"+aData.namaprogres+"</strong>" ).end();

                bootbox
                    .confirm( {
                    size: 'medium',
                    closeButton: false,
                    //title: 'SID - Delete Record',
                    message: formDelete,
                    buttons: {
                        'cancel': {
                            label: 'Cancel',
                            className: 'btn-default'
                        },
                        'confirm': {
                            label: 'Delete',
                            className: 'btn-danger'
                        }
                    },

                    callback: function(result) {
                        if(result) {
                            $.ajax({
                            type: "post",
                            dataType: "json",
                            url: siteurl+"Pemasaran/masterprogres/set_delete", // ajax source
                            data: { noid: aData.noid },                            
                            error: function (xhr, error, thrown) {
                                    App.alert({
                                        type: 'danger',
                                        icon: 'warning',
                                        message: xhr.responseText,
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                       // closeInSeconds: 3 // auto close in 5 seconds
                                    });
                                    },
                            success: function(result) {
                                    App.alert({
                                        type: 'success',
                                        icon: 'info',
                                        message: "Record has been deleted..",
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                        closeInSeconds: 3 // auto close in 5 seconds
                                    });
                                    oTable.ajax.reload();
                                }
                            });
                        }else {
                            App.alert({
                                        type: 'success',
                                        icon: 'info',
                                        message: "Record delete canceled..",
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                        closeInSeconds: 3 // auto close in 5 seconds
                                    });
                        }
                    }
                })
                .on('shown.bs.modal', function() {
                            formDelete.show();
                })

                .on('hide.bs.modal', function(e) {
                            formDelete.replaceWith(originalState.clone());
                            formDelete.hide().appendTo('body');
                });
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            handleTableDoc();
            handleTableProgresKPR();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesEditable.init();
});