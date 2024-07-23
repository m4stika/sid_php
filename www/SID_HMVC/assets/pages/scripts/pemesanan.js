var TableDatatablesEditable = function () {

    var handleTable = function () {
        var wrapper = $('#browsepemesanan');
        var wrapperform = $('#row_pemesanan');
        var formPemesanan = wrapperform.find('#form_pemesanan');
        var table = wrapper.find('#table_pemesanan');

        var polabayar = [
                {"state":"primary","caption":"KPR"},
                {"state":"warning","caption":"Tunai Keras"},
                {"state":"default","caption":"Tunai Bertahap"},
            ];  
        var statustran = [
                {"state":"primary", "status":"", "class":"bold", "caption":"Open"},
                {"state":"warning", "status":"disabled", "class":"", "caption":"Lock"},
                {"state":"success", "status":"disabled", "class":"", "caption":"Akad"},
                {"state":"danger", "status":"disabled", "class":"", "caption":"Closed"},
                {"state":"default", "status":"", "class":"bold", "caption":"Canceled"},
            ];

        var grid = new Datatable();

        //var oTable = table.DataTable({
        grid.init({
            src: table,
            onSuccess: function (grid, response) {
                // grid:        grid object
                // response:    json object of server side ajax response
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
            },
            dataTable: {
                "language": {
					"decimal": "",
					"thousands": ",",
    			},
                    
                "processing": true,
                "lengthMenu": [
                    [5,10, 20, 50, 100, 150, -1],
                    [5,10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                
                //setup responsive extension: http://datatables.net/extensions/responsive/
                // "responsive": {
                //     details: {
                //         renderer: function ( api, rowIdx, columns ) {
                //             var data = $.map( columns, function ( col, i ) {
                //                 return col.hidden ?
                //                     '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                //                         '<td class="bold">'+col.title+''+'</td> '+
                //                         '<td>'+col.data+'</td>'+
                //                     '</tr>' :
                //                     '';
                //             } ).join('');
             
                //             return data ?
                //                 $('<table/>').append( data ) :
                //                 false;
                //         }
                //     }
                // },

                "columns": [
                    { "data": "action", "title": "Actions",  "orderable": false, "searchable": false, 
                        render: function ( data, type, row, meta ) {
                            var dropdown = new gridDropdown();
                            var opt = dropdown.addDropdown(data, row.statustransaksi, false);
                            if (row.statustransaksi <= '1') {
                                opt += "<li class='divider'> </li>"+
                                       "<li> <a href='javascript:;' class='akad'> <i class='fa fa-thumbs-o-up'></i> Akad Jual Beli</a> </li>";
                            }
                            if (intVal(row.totalbayaronp) === 0 && intVal(row.totalbayar) > 0 && row.statustransaksi <= '1') { //Pop up Pembatalan konsumen
                                opt +=      "<li> <a href='javascript:;' class='batal'> <i class='fa fa-reply'></i> Konsumen Batal</a> </li>";
                            }

                            return opt;
                        }
                    },
                    { "data": "noid", "title": "#ID"},
                    { "data": "nopesanan", "title": "No. Pesanan"},
                    { "data": "polapembayaran", "title": "Pola Bayar",
                        render: function ( data, type, row, meta ) {
                            return "<span class='label label-sm label-"+polabayar[data].state+"'>"+polabayar[data].caption+"</span>";
                        }
                    },
                    { "data": "statustransaksi", "title": "Status",
                        render: function ( data, type, row, meta ) {
                            
                            return "<span class='label label-sm label-"+statustran[data].state+"'>"+statustran[data].caption+"</span>";
                        }
                    },
                    { "data": "namapemesan", "title": "Nama"},
                    { "data": "blok", "title": "Blok"},
                    { "data": "nokavling", "title": "No Kavling"},
                    { "data": "typerumah", "title": "Type Tumah"},
                    { "data": "hargajual", "title": "Harga"},
                    { "data": "diskon", "title": "Diskon"},
                    { "data": "hargaklt", "title": "KLT"},
                    { "data": "hargasudut", "title": "Sudut"},
                    { "data": "hargahadapjalan", "title": "Hadap Jln"},
                    { "data": "hargafasum", "title": "Fasum"},
                    { "data": "hargaredesign", "title": "Redesign"},
                    { "data": "hargatambahkwalitas", "title": "Tambah Kw."},
                    { "data": "hargapekerjaantambah", "title": "Kerja Tambah"},
                    { "data": "totalharga", "title": "Total Hrg"},
                    { "data": "bookingfee", "title": "booking Fee"},
                    { "data": "totaluangmuka", "title": "Uang Muka"},
                    { "data": "bookingfeebyr", "title": "Booking Fee"},
                    { "data": "lunasuangmuka", "title": "Uang Muka"},
                    { "data": "hargaredesign", "title": "Redesign"},
                    { "data": "hargasudutbyr", "title": "Sudut"},
                    { "data": "hargahadapjalanbyr", "title": "Hadap Jln"},
                    { "data": "hargafasumbyr", "title": "Fasum"},
                    { "data": "hargaredesignbyr", "title": "Redesign"},
                    { "data": "hargatambahkwbyr", "title": "Tambah Kw."},
                    { "data": "hargakerjatambahbyr", "title": "Kerja Tambah"},
                    { "data": "totalhargabyr", "title": "Angsuran"},
                    { "data": "totalbayar", "title": "Total Bayar"},
                    { "data": "totalbayartitipan", "title": "Titipan"},
                    { "data": "totalhutang", "title": "SALDO"}
                ],      

				"columnDefs": [ 
                    {
					  "targets": [0,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],
					  "orderable": false,
					},					
					{
						"targets": [10,11,12,13,14,15,16,17,21,22,23,24,25,26,27,28,29,30,31,32],
						"render": $.fn.dataTable.render.number( '.', ',', 0, '' ),
						"className": 'dt-right'
					},
                    {
                        "targets": [9], //HARGA JUAL
                        "render": $.fn.dataTable.render.number( '.', ',', 0, '' ),
                        "className": 'dt-right info bold'                          
                    },
                    {
                        "targets": [18,19, 20], //TOTAL HARGA JUAL
                        "render": $.fn.dataTable.render.number( '.', ',', 0, '' ),
                        "className": 'dt-right warning bold'                          
                    },
                    {
                        "targets": [33], //SALDO
                        "render": $.fn.dataTable.render.number( '.', ',', 0, '' ),
                        "className": 'dt-right success bold'
                    },
                				
					],

                "ajax": {
                    type: "post",
                    dataType: "json",					
                    url: siteurl+"Pemasaran/Pemesanan/pemesanan_datatable",
					error: function (xhr, error, thrown) {
								App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: grid.gettableContainer(),
                                    place: 'prepend',
                                    //closeInSeconds: 3 // auto close in 5 seconds
                                });
                                App.unblockUI(wrapper.find('.table-container'));
							}
                },
				buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
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
                ],// set first column as a default sort by asc
                // scroller:       true,
                //deferRender:    true,
                scrollX:        true,
                //scrollCollapse: true, 
            }
        });
        var nTable = grid.getDataTable();

        wrapperform.find('.portlet > .portlet-title > .actions > .back').removeClass('hidden');

        // handle datatable custom tools
        $('#datatable_ajax_tools > li > a.tool-action').on('click', function() {    
            var action = $(this).attr('data-action');
            grid.getDataTable().button(action).trigger();
        });

        //Cancel / Back
        wrapperform.on("click",".back",function(e){    
            e.preventDefault();
            //formPemesanan.find('#nokavling').find('[value = '+response.data.idkavling+']').removeAttr('disabled');
            wrapper.slideDown('fast', function(){
                wrapperform.hide(); 
            });
            
        })

        wrapper.on('click','.new',function(e) {
            e.preventDefault();
            wrapperform.find('.reset').trigger('click');
            //wrapperform.find('select[name=nokavling]').html(nokavlingOption);
            //wrapperform.find('select[name=nokavling]').selectpicker('refresh');
            wrapper.slideUp('fast', function(){
                wrapper.hide();
                wrapperform.show(); 
            });
        });

        //Edit & copy
        wrapper.on('click', '.edit, .copy', function(e) {
            var aData = nTable.row('.selected').data();
            if (aData === undefined) {
                var rowindex = (this).closest('tr').rowIndex;
                aData = nTable.row(rowindex-1).data();
            }
            handleEditCopy(e,aData);
        });

        //Delete
        wrapper.on('click', '.delete', function(e) {
            var aData = nTable.row('.selected').data();
            if (aData === undefined) {
                var rowindex = (this).closest('tr').rowIndex;
                aData = nTable.row(rowindex-1).data();
            }
            handleDelete(e, aData);
        });

        wrapper.on("click",".export",function(e){    
            $.ajax( {
                type: "post",
                url: siteurl+"Pemasaran/pemesanan/pemesanan_ExportXLS",
                error: function (xhr, error, thrown) {                                  
                            App.alert({
                                type: 'danger',
                                icon: 'warning',
                                message: xhr.responseText,
                                container: grid.gettableContainer(),
                                place: 'prepend',
                                //closeInSeconds: 3 // auto close in 5 seconds
                            });
                        },
                success: function(result) { 
                        App.alert({
                            type: 'success',
                            icon: 'info',
                            message: "Export has been Complated..",
                            container: grid.gettableContainer(),
                            place: 'prepend',
                            closeInSeconds: 3 // auto close in 5 seconds
                        });
                    }
            });
            
        });

        var formDelete = $('#row_delete');
        var handleDelete = function(e, aData) {
            //var aData = grid.getDataTable().row('.selected').data();
            var originalState = formDelete.clone();
           // console.log(aData);
            e.preventDefault();
            formDelete
                .find('[id="noid"]').text(aData.noid).end()
                .find('[id="namapemesan"]').text(aData.namapemesan).end()
                .find('[id="kavling"]').text(aData.nokavling).end()
                .find('[id="typerumah"]').text(aData.typerumah).end();

                bootbox
                    .dialog( {
                    //size: 'medium',
                    closeButton: false,
                   // title: 'SID - Delete Record',
                    message: formDelete,
                    buttons: {
                        'cancel': {
                            label: 'Cancel',
                            className: 'btn-default'
                        },
                        'confirm': {
                            label: 'Delete',
                            className: 'btn-danger',
                            callback: function(result) {
                                //result will be true if button was click, while it will be false if users close the dialog directly.
                                $.ajax({
                                type: "post",
                                dataType: "json",
                                url: siteurl+"Pemasaran/pemesanan/delete_pemesanan", // ajax source
                                data: { noid: aData[2], flag: 3 },                            
                                error: function (xhr, error, thrown) {
                                            App.alert({
                                                type: 'danger',
                                                icon: 'warning',
                                                message: xhr.responseText,
                                                container: grid.gettableContainer(),
                                                place: 'prepend',
                                                //closeInSeconds: 3 // auto close in 5 seconds
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
                                        nTable.ajax.reload();
                                    }
                                });
                            } //end of callback
                        }
                    } //end of buttons
                }) //end of dialog
                .on('shown.bs.modal', function() {
                            formDelete.show();
                })

                .on('hide.bs.modal', function(e) {
                            formDelete.replaceWith(originalState.clone());
                            formDelete.hide().appendTo('body');
                });
        };
        
        var handleEditCopy = function(e, aData) {
            wrapperform.find('select[name=nokavling]').html(nokavlingOption);
            wrapperform.find('select[name=nokavling]').selectpicker('refresh');
            formPemesanan.trigger('reset');
            var status = '';
            if ($(e.target).hasClass('edit')||$(e.target).parent().hasClass('edit')) { 
                formPemesanan.find('#crud').val("edit");
                wrapperform.find('.page-title').html("Pemasaran <small>Edit pemesanan</small>");
                wrapperform.find('.caption-subject').text("Edit pemesanan");
                status = 'edit';
            } else {
                formPemesanan.find('#crud').val("copy");
                wrapperform.find('.page-title').html("Pemasaran <small>Copy pemesanan</small>");
                wrapperform.find('.caption-subject').text("Copy pemesanan");
                status = 'copy';
            }

            wrapperform.find('.caption-helper').html(' | '+statustran[status == 'copy' ? 0 : aData.statustransaksi].caption);
            
            e.preventDefault();
            $.ajax({
                    type: "post",
                    dataType: "json",
                    url: siteurl+"Pemasaran/pemesanan/get_record", // ajax source
                    data : {
                        noid: aData.noid
                    },
                    error: function (xhr, error, thrown) {
                                App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: grid.gettableContainer(),
                                    place: 'prepend',
                                   // closeInSeconds: 3 // auto close in 5 seconds
                                });
                            }
                }).success(function(response) {
                    formPemesanan
                        .find('#idpemesanan').text((status == 'edit') ? '#'+response.data.noid : -1).end()
                        .find('#noidpemesanan').val((status == 'edit') ? response.data.noid : -1).end()
                        .find('#nopesanan').val(response.data.nopesanan).end()
                        .find('[name="namapemesan"]').val(response.data.namapemesan).end()
                        .find('[name="alamatpemesan"]').val(response.data.alamatpemesan).end()
                        .find('[name="rtrwpemesan"]').val(response.data.rtrwpemesan).end()
                        .find('[name="kelurahanpemesan"]').val(response.data.kelurahanpemesan).end()
                        .find('[name="kecamatanpemesan"]').val(response.data.kecamatanpemesan).end()
                        .find('[name="kabupatenpemesan"]').val(response.data.kabupatenpemesan).end()
                        .find('[name="telprumahpemesan"]').val(response.data.telprumahpemesan).end()
                        .find('[name="telpkantorpemesan"]').val(response.data.telpkantorpemesan).end()
                        .find('[name="hp1pemesan"]').val(response.data.hp1pemesan).end()
                        .find('[name="hp2pemesan"]').val(response.data.hp2pemesan).end()
                        .find('[name="namapasangan"]').val(response.data.namapasangan).end()
                        .find('[name="alamatpasangan"]').val(response.data.alamatpasangan).end()
                        .find('[name="rtrwpasangan"]').val(response.data.rtrwpasangan).end()
                        .find('[name="kelurahanpasangan"]').val(response.data.kelurahanpasangan).end()
                        .find('[name="kecamatanpasangan"]').val(response.data.kecamatanpasangan).end()
                        .find('[name="kabupatenpasangan"]').val(response.data.kabupatenpasangan).end()
                        .find('[name="telprumahpasangan"]').val(response.data.telprumahpasangan).end()
                        .find('[name="telpkantorpasangan"]').val(response.data.telpkantorpasangan).end()
                        .find('[name="hp1pasangan"]').val(response.data.hp1pasangan).end()
                        .find('[name="hp2pasangan"]').val(response.data.hp2pasangan).end()
                        .find('[id="dptglpesanan"]').datepicker('update',response.data.tglpesanan).end()
                        .find('[id="tgl_pesanan"]').val($('#dptglpesanan').datepicker('getFormattedDate','yyyy-mm-dd')).end();
                        formPemesanan.find('select[name=nokavling]').selectpicker('val',-1);
                    if (status == 'edit') {
                      formPemesanan
                        .find('[name="luasbangunan"]').val(response.data.luasbangunan).end()
                        .find('[name="luastanah"]').val(response.data.luastanah).end()
                        .find('[name="hargajual"]').val(response.data.hargajual).end()
                        .find('[name="diskon"]').val(response.data.diskon).end()
                        //.find('[name="diskon"]').val(150000).end()
                        .find('[name="kelebihantanah"]').val(response.data.kelebihantanah).end()
                        .find('[name="hargakltm2"]').val(response.data.hargakltm2).end()
                        .find('[name="hargaklt"]').val(response.data.hargakltm2 * response.data.kelebihantanah).end()

                        .find('[id="sudut"]').prop('checked',((response.data.sudut==1) ? true : false)).end()
                        .find('[name="hargasudut"]').each(function() {
                            $(this).val((response.data.sudut==1) ? response.data.hargasudut : 0);
                            $(this).prop('readonly', (response.data.sudut==1) ? false : true);
                        }).end()
                        .find('[id="hadapjalan"]').prop('checked',((response.data.hadapjalan==1) ? true : false)).end()
                        .find('[name="hargahadapjalan"]').each(function() {
                            $(this).val((response.data.hadapjalan==1) ? response.data.hargahadapjalan : 0);
                            $(this).prop('readonly', (response.data.hadapjalan==1) ? false : true);
                        }).end()
                        .find('[id="fasum"]').prop('checked',((response.data.fasum==1) ? true : false)).end()
                        .find('[name="hargafasum"]').each(function() {
                            $(this).val((response.data.fasum==1) ? response.data.hargafasum : 0);
                            $(this).prop('readonly', (response.data.fasum==1) ? false : true);
                        }).end()
                        .find('[id="redesignbangunan"]').prop('checked',((response.data.redesignbangunan==1) ? true : false)).end()
                        .find('[name="hargaredesign"]').each(function() {
                            $(this).val((response.data.redesignbangunan==1) ? response.data.hargaredesign : 0)
                            $(this).prop('readonly', (response.data.redesignbangunan==1) ? false : true);
                        }).end()
                        .find('[id="tambahkwalitas"]').prop('checked',((response.data.tambahkwalitas==1) ? true : false)).end()
                        .find('[name="hargatambahkwalitas"]').each(function() {
                            $(this).val((response.data.tambahkwalitas==1) ? response.data.hargatambahkwalitas : 0)
                            $(this).prop('readonly', (response.data.tambahkwalitas==1) ? false : true);
                        }).end()
                        .find('[id="pekerjaantambah"]').prop('checked',((response.data.pekerjaantambah==1) ? true : false)).end()
                        .find('[name="hargapekerjaantambah"]').each(function() {
                            $(this).val((response.data.pekerjaantambah==1) ? response.data.hargapekerjaantambah : 0)
                            $(this).prop('readonly', (response.data.pekerjaantambah==1) ? false : true);
                        }).end()
                        .find('[name="totalharga"]').val(response.data.totalharga).end()
                        .find('[name="bookingfee"]').val(response.data.bookingfee).end()
                        .find('[name="totaluangmuka"]').val(response.data.totaluangmuka).end()
                        .find('[name="hpp"]').val(response.data.hpp).end()
                        .find('[name="plafonkpr"]').val(response.data.plafonkpr).end()
                        .find('[name="lamaangsuran"]').val(response.data.lamaangsuran).end()
                        .find('[name="nilaiangsuran"]').val(response.data.nilaiangsuran).end();
                        formPemesanan.find('select[name=nokavling]').selectpicker('val',response.data.idkavling);
                        formPemesanan.find('#nokavling').find('[value = '+response.data.idkavling+']').removeAttr('disabled');
                        formPemesanan.find('select[name=nokavling]').selectpicker('refresh');
                    }

                        formPemesanan.find('select[name=typekonsumen]').selectpicker('val',response.data.jenispesanan);
                        formPemesanan.find('select[name=polabayar]').selectpicker('val',response.data.polapembayaran);

                        //formPemesanan.find('select[name=nokavling]').selectpicker('val',(status == 'edit') ? response.data.idkavling : -1);
                        //formPemesanan.find('#nokavling').find('[value = '+response.data.idkavling+']').removeAttr('disabled');
                        


                        formPemesanan.find('#polabayar').change();
                        formPemesanan.find('#typekonsumen').change();
                        formPemesanan.find('.change-total').change();

                    if (response.hasil == "OK") {
                        wrapper.hide()
                        wrapperform.show();
                    } else console.log('No Record to display');
                });
        }        

        // ------------------ Scrip PAYMENT ---------------//
        //Payment Button Click
        wrapper.on('click','.payment',function(e) {
            var aData = grid.getSelectedRows();
            document.location.href=siteurl+"Pemasaran/pembayaran/index/"+aData.noid+"/browsepemesanan";          
        });

        // -------------------------------------------------------//
        // ------------------ Scrip KONSUMEN BATAL ---------------//
        // -------------------------------------------------------//
        var wrapperBatal = $('#row_batal');
        var formBatal = wrapperBatal.find('#form_batal');
        formBatal.on('change','.change-total', function() {
            var polabayar =  $('#form_pembayaran #polapembayaran').text();
        
            var total;
            if (polabayar == '0') //KPR
            {
                total = parseInt(formBatal.find('#bookingfee').val()) + 
                        parseInt(formBatal.find('#uangmuka').val()) + 
                        parseInt(formBatal.find('#hargaklt').val()) + 
                        parseInt(formBatal.find('#hargasudut').val()) + 
                        parseInt(formBatal.find('#hargahadapjalan').val()) + 
                        parseInt(formBatal.find('#hargafasum').val()) + 
                        parseInt(formBatal.find('#hargaredesign').val()) + 
                        parseInt(formBatal.find('#hargatambahkwalitas').val()) + 
                        parseInt(formBatal.find('#hargapekerjaantambah').val());
            
            } else  {
                total = parseInt(formBatal.find('#bookingfee').val()) + 
                        parseInt(formBatal.find('#uangmuka').val()) + 
                        parseInt(formBatal.find('#totalangsuran').val());
            }
            formBatal.find('#total').val(total);
            total = undefined;
        });

        // Tanggal Pembayaran Onchange
        formBatal.on('changeDate','#dptglpembatalan', function(ev){
            formBatal.find('#tglbatal').val(formBatal.find('#dptglpembatalan').datepicker('getFormattedDate','yyyy-mm-dd'));
        });

        formBatal.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            rules: {
                hargajual: {required: true},
                cbbankout: {required: true},
                nobukti: {required: true},
                alasanbatal: {required: true},
            },
            messages:
            {
                hargajual:{required: "Nomor Kavling Perlu diisi"},
                cbbankout:{required: "Bank Pengeluaran harus diisi"},
                nobukti:{required: "Nomor Bukti harus diisi"},
                alasanbatal:{required: "Alasan Pembatalan harus diisi"},
                tglpembatalan:{required: "Tanggal Pemesanan harus diisi"},
                total:{required: "Total Pengembalian harus diisi"}
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            submitHandler: function(e){
                var data = formBatal.serialize();
                $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: siteurl+'Pemasaran/pemesanan/pembatalan_pemesanan', // ajax source
                        data: data, //{data, dataTable: datatable},
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
                            if (response == true) { //error server validation
                                App.alert({
                                        type: 'success',
                                        icon: 'info',
                                        message: "tidak ada Pengembalian",
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                        closeInSeconds: 3 // auto close in 5 seconds
                                    });
                            } else {
                                App.alert({
                                        type: 'success',
                                        icon: 'info',
                                        message: "Process Complated..",
                                        container: grid.gettableContainer(),
                                        place: 'prepend',
                                        closeInSeconds: 3 // auto close in 5 seconds
                                    });
                                formBatal.trigger('reset');
                                grid.getDataTable().ajax.reload();
                                wrapperBatal.modal('hide');
                            }
                        });
                data = undefined;
                return false;
            }
        });

        table.on('click', '.batal', function(e) {
            var rowindex = (this).closest('tr').rowIndex;
            var aData = nTable.row(rowindex-1).data();
            //var aData = grid.getData($(this).parents('tr')[0]);
            $.ajax({ //Get Data From Server
                type: 'post',
                dataType: 'json',
                url: siteurl+"Pemasaran/pemesanan/get_record",
                data : {noid: aData.noid},
                error: function (xhr, error, thrown) {
                        App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: xhr.responseText,
                            container: grid.gettableContainer(),
                            place: 'prepend',
                            //closeInSeconds: 3 // auto close in 5 seconds
                        });
                    }
            }).success(function(response) { 
                showformbatal(response.data);
            });

            function showformbatal(data) { 
                formBatal.trigger('reset');
                clearValidation('#form_batal');
                var address = "<strong>"+data.namapemesan+"</strong>";
                    address += "<br/> "+data.alamatpemesan+ ", RT/RW :"+ data.rtrwpemesan;
                    address += "<br/> "+data.kelurahanpemesan+ " - "+ data.kecamatanpemesan;
                    address += "<br/> "+data.kabupatenpemesan;
                    address += "<br/>";
                    address += "<abbr title='Phone'>P:</abbr> "+data.telprumahpemesan;
                (parseInt(data.totalbayar) > 0) ? formBatal.find('.blokpembayaran').removeClass('hidden') : formBatal.find('.blokpembayaran').addClass('hidden');
                formBatal
                    .find('[id="noid"]').val(data.noid).end()
                    .find('[id="nokavling"]').val(data.idkavling).end()
                    .find('[id="polapembayaran"]').text(data.polapembayaran).end()
                    .find('[id="nopesanan"]').text(data.noid+'|'+data.nopesanan).end()
                    .find('address').html(address).end()
                    .find('[id="kavling"]').text(data.idkavling+'|'+data.typerumah+'|'+data.keterangan).end()
                    .find('[id="tgltransaksi"]').text(data.tglpesanan).end()
                    .find('[id="totaltransaksi"]').val(data.totalharga).end()
                if (parseInt(data.totalbayar) > 0) {    
                    formBatal
                    .find('[id="bookingfeebyr"]').each(function() {
                                $(this).val(data.bookingfeebyr);
                                (parseInt(data.bookingfeebyr) > 0) ? formBatal.find('.blokbookingfee').addClass('hidden') : formBatal.find('.blokbookingfee').addClass('hidden');
                                formBatal.find('#bookingfee')
                                    .attr('readonly', (parseInt(data.bookingfeebyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.bookingfeebyr)})
                                    .val(0);
                        }).end()
                    .find('[id="uangmukabyr"]').each(function() {
                                $(this).val(data.lunasuangmuka);
                                (parseInt(data.lunasuangmuka) > 0) ? formBatal.find('.blokuangmuka').removeClass('hidden') : formBatal.find('.blokuangmuka').addClass('hidden');
                                formBatal.find('#uangmuka')
                                    .attr('readonly', (parseInt(data.lunasuangmuka) > 0) ? false : true)
                                    .attr({"max": parseInt(data.lunasuangmuka)})
                                    .val(0);
                        }).end()
                    .find('[id="hargakltbyr"]').each(function() {
                                $(this).val(data.hargakltbyr);
                                (parseInt(data.hargakltbyr) > 0) ? formBatal.find('.blokklt').removeClass('hidden') : formBatal.find('.blokklt').addClass('hidden');

                                formBatal.find('#hargaklt')
                                    .attr('readonly', (parseInt(data.hargakltbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargakltbyr)})
                                    .val(0)
                        }).end()
                    .find('[id="hargasudutbyr"]').each(function() {
                                $(this).val(data.hargasudutbyr);
                                (parseInt(data.hargasudutbyr) > 0) ? formBatal.find('.bloksudut').removeClass('hidden') : formBatal.find('.bloksudut').addClass('hidden');
                                formBatal.find('#hargasudut')
                                    .attr('readonly', (parseInt(data.hargasudutbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargasudutbyr)})
                                    .val(0)
                        }).end()
                    .find('[id="hargahadapjalanbyr"]').each(function() {
                                $(this).val(data.hargahadapjalanbyr);
                                (parseInt(data.hargahadapjalanbyr) > 0) ? formBatal.find('.blokhadapjalan').removeClass('hidden') : formBatal.find('.blokhadapjalan').addClass('hidden');
                                formBatal.find('#hargahadapjalan')
                                    .attr('readonly', (parseInt(data.hargahadapjalanbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargahadapjalanbyr)})
                                    .val(0)
                        }).end()
                    .find('[id="hargahadapjalanbyr"]').each(function() {
                                $(this).val(data.hargahadapjalanbyr);
                                (parseInt(data.hargahadapjalanbyr) > 0) ? formBatal.find('.blokhadapjalan').removeClass('hidden') : formBatal.find('.blokhadapjalan').addClass('hidden');
                                formBatal.find('#hargahadapjalan')
                                    .attr('readonly', (parseInt(data.hargahadapjalanbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargahadapjalanbyr)})
                                    .val(0)
                        }).end()
                    .find('[id="hargafasumbyr"]').each(function() {
                                $(this).val(data.hargafasumbyr);
                                (parseInt(data.hargafasumbyr) > 0) ? formBatal.find('.blokfasum').removeClass('hidden') : formBatal.find('.blokfasum').addClass('hidden');
                                formBatal.find('#hargafasum')
                                    .attr('readonly', (parseInt(data.hargafasumbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargafasumbyr)})
                                    .val(0)
                        }).end()
                    .find('[id="hargaredesignbyr"]').each(function() {
                                $(this).val(data.hargaredesignbyr);
                                (parseInt(data.hargaredesignbyr) > 0) ? formBatal.find('.blokredesign').removeClass('hidden') : formBatal.find('.blokredesign').addClass('hidden');
                                formBatal.find('#hargaredesign')
                                    .attr('readonly', (parseInt(data.hargaredesignbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargaredesignbyr)})
                                    .val(0)
                        }).end()
                    .find('[id="hargatambahkwbyr"]').each(function() {
                                $(this).val(data.hargatambahkwbyr);
                                (parseInt(data.hargatambahkwbyr) > 0) ? formBatal.find('.bloktambahkw').removeClass('hidden') : formBatal.find('.bloktambahkw').addClass('hidden');
                                formBatal.find('#hargatambahkwalitas')
                                    .attr('readonly', (parseInt(data.hargatambahkwbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargatambahkwbyr)})
                                    .val(0);
                        }).end()
                    .find('[id="hargakerjatambahbyr"]').each(function() {
                                $(this).val(data.hargakerjatambahbyr);
                                (parseInt(data.hargakerjatambahbyr) > 0) ? formBatal.find('.bloktambahkontruksi').removeClass('hidden') : formBatal.find('.bloktambahkontruksi').addClass('hidden');
                                formBatal.find('#hargapekerjaantambah')
                                    .attr('readonly', (parseInt(data.hargakerjatambahbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.hargakerjatambahbyr)})
                                    .val(0);
                        }).end()
                    .find('[id="totalangsuranbyr"]').each(function() {
                                $(this).val(data.totalangsuranbyr);
                                (parseInt(data.totalangsuranbyr) > 0) ? formBatal.find('.bloktunai').removeClass('hidden') : formBatal.find('.bloktunai').addClass('hidden');
                                formBatal.find('#totalangsuran')
                                    .attr('readonly', (parseInt(data.totalangsuranbyr) > 0) ? false : true)
                                    .attr({"max": parseInt(data.totalangsuranbyr)})
                                    .val(0);
                        }).end()
                    .find('#totalbyr').val(data.totalbayar).end();
                }

                wrapperBatal.modal({backdrop: 'static', keyboard: false, show: true});
            }
        });
        // END OF Scrip KONSUMEN BATAL ---------------//

        // -------------------------------------------------------//
        // ------------------ Scrip AKAD JUAL BELI ---------------//
        // -------------------------------------------------------//
        var wrapperAkad = $('#row_akad');
        var formAkad = wrapperAkad.find('#form_akad');
        var formRincian = wrapperAkad.find('.form_rincian');
        var oTable = wrapperAkad.find('#table_rincianakad').DataTable({
            "dom": "<t>",
            "ordering": false,
            "columnDefs": [
                {
                    "targets": [4],
                    "render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
                    "className": 'dt-right bold bg-success',                        
                    "type": "num"
                },
            ],
            "columns": [
                { "name": "cut"},
                { "name": "rekid"},
                { "name": "accno"},
                { "name": "description"},
                { "name": "amount"}
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     
                // Total over all pages
                total = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Update footer
                $( api.column( 4 ).footer() ).html(
                    'Rp. '+ total.format(2, 3, '.', ',')
                );

                formAkad.find('#retensikpr').val(total);
                formAkad.find('#realisasikpr').val($('#row_akad #plafonkpr').val() - total);                
            },
        });

        // Tanggal akad Onchange
        formAkad.on('changeDate','#dptglakad', function(ev){
            formAkad.find('#tglakad').val(formAkad.find('#dptglakad').datepicker('getFormattedDate','yyyy-mm-dd'));
        });

        wrapperAkad.on('click','.add', function(){
            var aData = formRincian.find('#cbbankrincian').find(":selected").data('value');
            oTable.row.add(["<a class='cut label label-sm label-danger' data-value=''>delete</a>",aData.rekid,aData.accountno, aData.description, formRincian.find('#nilaikprdetail').val()]).draw(false);
            
            formRincian
            .find('#nilaikprdetail').val(0).end()
            .find('select[name=cbbankrincian]').selectpicker('val',"").end();
                                //"<a class='delete label label-sm label-info' data-value=''>delete</a>",
                                //'<input type="hidden" value="0" name="detailnilai[nilairp_' + rowcount + ']" id="nilairp_' + rowcount + '">',
                                //'<input type="hidden" value="'+data.noid+'" name="detilrekid[rekid_' + rowcount + ']" id="rekid_' + rowcount + '">',
        });

        wrapperAkad.on('click','.cut', function(){ //delete item rincian 
            oTable
            .row( $(this).parents('tr') )
            .remove()
            .draw();
        });

        var polapembayaran = 0;

        //Form akad Validation
        formAkad.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: true, // do not focus the last invalid input
            rules: {
                tglakadkredit: {required: true},
                retensikpr: {required: true},
                accbankretensi: {required: true},
                accbankkpr: {required: true},
            },
            messages:
            {
                tglakadkredit:{required: "Tanggal Akad Perlu diisi"},
                retensikpr:{required: "Retensi KPR harus diisi"},
                accbankretensi:{required: "Bank Penerimaan Retensi harus diisi"},
                accbankkpr:{required: "Bank Penerimaan KPR harus diisi"},
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            submitHandler: function(e){
                var data;
                if (polapembayaran == '0') {
                    var rows = [];
                    var table = $('#table_rincianakad');
                    var no = 0;
                    $('tbody > tr', table).each(function() {
                        var item = {};
                        no++;
                        item.idpemesanan = $('#form_akad #noid').val();
                        item.indexvalue = no;
                        item.linkacc = oTable.row($(this)).data()[1];
                        item.amount = oTable.row($(this)).data()[4];
                        rows.push(item);
                    });
                    data = formAkad.serialize()+"&polapembayaran="+polapembayaran+"&detail="+JSON.stringify(rows);
                } else data = formAkad.serialize()+"&polapembayaran="+polapembayaran;

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: siteurl+'Pemasaran/pemesanan/akadjualbeli', // ajax source
                    data: data, 
                    error: function (xhr, error, thrown) {
                                App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: grid.gettableContainer(),
                                    place: 'prepend',
                                    //closeInSeconds: 3 // auto close in 5 seconds
                                });
                            }
                }).success(function(response) {
                        if (response == false) { //error server validation
                            App.alert({
                                type: 'danger',
                                icon: 'warning',
                                message: 'Error Saving Record',
                                container: grid.gettableContainer(),
                                place: 'prepend',
                                //closeInSeconds: 3 // auto close in 5 seconds
                            });
                        } else {
                            App.alert({
                                type: 'success',
                                icon: 'info',
                                message: "Process Complated..",
                                container: grid.gettableContainer(),
                                place: 'prepend',
                                closeInSeconds: 3 // auto close in 5 seconds
                            });
                            grid.getDataTable().ajax.reload();
                            wrapperAkad.modal('hide');
                            //resetform();
                        }
                    });
                return false;
            }
        }); //end of validation

        grid.getTable().on('click', '.akad', function(e) {
            e.preventDefault();
            var rowindex = (this).closest('tr').rowIndex;
            var aData = nTable.row(rowindex-1).data();
            //var aData = grid.getData($(this).parents('tr')[0]);

            $.ajax({ //Get Data From Server
                type: 'post',
                dataType: 'json',
                url: siteurl+"Pemasaran/pemesanan/get_record",
                data : {noid: aData.noid},
                error: function (xhr, error, thrown) {
                        App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: xhr.responseText,
                            container: grid.gettableContainer(),
                            place: 'prepend',
                            //closeInSeconds: 3 // auto close in 5 seconds
                        });
                    }
            }).success(function(response) { 
                showformakad(response.data);                
            });

            function showformakad(data) { 
                polapembayaran = data.polapembayaran;
                formAkad.trigger('reset');
                oTable.clear().draw();
                clearValidation('#form_akad');

                (data.polapembayaran == '0') ? wrapperAkad.find('.blok_akadkpr').removeClass('hidden') : wrapperAkad.find('.blok_akadkpr').addClass('hidden');

                var address = "<strong>"+data.namapemesan+"</strong>";
                    address += "<br/> "+data.alamatpemesan+ ", RT/RW :"+ data.rtrwpemesan;
                    address += "<br/> "+data.kelurahanpemesan+ " - "+ data.kecamatanpemesan;
                    address += "<br/> "+data.kabupatenpemesan;
                    address += "<br/>";
                    address += "<abbr title='Phone'>P:</abbr> "+data.telprumahpemesan;

                wrapperAkad
                    .find('#noid').val(data.noid).end()
                    .find('#nokavling').val(data.idkavling).end()
                    .find('#polapembayaran').text(data.polapembayaran).end()
                    .find('#nopesanan').text(data.noid+'|'+data.nopesanan).end()
                    .find('address').html(address).end()
                    .find('#kavling').text(data.idkavling+'|'+data.typerumah+'|'+data.keterangan).end()
                    .find('#tgltransaksi').text(data.tglpesanan).end()
                    .find('#plafonkprinfo').val(data.plafonkpr).end()
                    .find('#plafonkpr').val(data.plafonkpr).end()
                    .find('#realisasikpr').val(data.plafonkpr).end()
                    .find('#retensikpr').val(0).end()
                    .find('#totaltransaksi').val(data.totalharga).end()
                    .find('#nilaikprdetail').val(0).end()
                    .find('select[name=cbbankrincian]').selectpicker('val',"").end();
                wrapperAkad.modal({backdrop: 'static', keyboard: false, show: true});
            }
        });
        // END OF Scrip AKAD JUAL BELI ---------------//
    };

    return {
        //main function to initiate the module
        init: function () {
            handleTable();       
        }

    };

}();

   
jQuery(document).ready(function() {
    TableDatatablesEditable.init();
     
});