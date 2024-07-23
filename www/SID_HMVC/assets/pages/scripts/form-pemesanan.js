var formPemesanan = function () {
	
	var handleForm = function() {
		var wrapper = $('#row_pemesanan');
        var formPemesanan = wrapper.find('#form_pemesanan');
		function resetform() {
			formPemesanan.trigger('reset');
			formPemesanan
				.find('[id="crud"]').val('new').end()
				.find('[id="idpemesanan"]').text('-1').end()
				.find('[id="noidpemesanan"]').val(-1).end()
				.find('[id= "typekonsumen"]').change().end()
				.find('[id= "dptglpesanan"]').datepicker('update',new Date()).end()
				.find('[id= "tgl_pesanan"]').val($('#dptglpesanan').datepicker('getFormattedDate','yyyy-mm-dd')).end();
                formPemesanan.find('select[name=nokavling]').html(nokavlingOption);
                formPemesanan.find('select[name=nokavling]').selectpicker('refresh');
                formPemesanan.find('select[name=nokavling]').selectpicker('val',-1);
				wrapper.find('.caption-subject').text("pemesanan");
                wrapper.find('.caption-helper').html(' | Open');
				//wrapper.find('.portlet > .portlet-title > .caption > #pemesantitle').html(' | '+"<span class=\"label label-sm label-primary\"> Open </span>");
				wrapper.find('.portlet-title > .actions > .save').prop('disabled','disabled');
		}

		//Calculate Total
        formPemesanan.on('change','.change-total', function() {           
            var total = parseInt(formPemesanan.find('#hargajual').val()) - parseInt(formPemesanan.find('#diskon').val()) + parseInt(formPemesanan.find('#hargaklt').val()) +
                        parseInt(formPemesanan.find('#hargasudut').val()) + parseInt(formPemesanan.find('#hargahadapjalan').val()) + parseInt(formPemesanan.find('#hargafasum').val()) +
                        parseInt(formPemesanan.find('#hargaredesign').val()) + parseInt(formPemesanan.find('#hargatambahkwalitas').val()) + parseInt(formPemesanan.find('#hargapekerjaantambah').val());
            formPemesanan.find('#totalharga').val(total);
            var totalangsuran = (total - parseInt(formPemesanan.find('#totaluangmuka').val()));

            if (formPemesanan.find('#polabayar').val() == 0) {
                formPemesanan.find('#plafonkpr').val(totalangsuran);
                formPemesanan.find('#nilaiangsuran').val(0);
                formPemesanan.find('#lamaangsuran').val(1);
            } else {
                var nilaiangsuran = totalangsuran / parseInt(formPemesanan.find('#lamaangsuran').val()) ;
                formPemesanan.find('#nilaiangsuran').val(nilaiangsuran);
                formPemesanan.find('#plafonkpr').val(0);
            }

            wrapper.find('.portlet-title > .actions > .save').removeAttr('disabled');
        });

        //changed.bs.select Combao Kavling
         formPemesanan.on('changed.bs.select','#nokavling',function(e, clickedIndex, newValue, oldValue) {
            var selectedD = $(this).find('option:eq(' + clickedIndex + ')').data('value');
            formPemesanan
                        .find('[name="luasbangunan"]').val(selectedD.luasbangunan).end()
                        .find('[name="luastanah"]').val(selectedD.luastanah).end()
                        .find('[name="hargajual"]').val(selectedD.hargajual).end()
                        .find('[name="kelebihantanah"]').val(selectedD.kelebihantanah).end()
                        .find('[name="hargakltm2"]').val(selectedD.hargakltm2).end()
                        .find('[name="hargaklt"]').val(selectedD.hargakltm2 * selectedD.kelebihantanah).end()
                        .find('[id="sudut"]').prop('checked',((selectedD.sudut==1) ? true : false)).end()
                        .find('[name="hargasudut"]').each(function() {
                            $(this).val((selectedD.sudut==1) ? selectedD.hargasudut : 0);
                            $(this).attr('readonly', (selectedD.sudut==1) ? false : true);
                        }).end()
                        .find('[id="hadapjalan"]').prop('checked',((selectedD.hadapjalan==1) ? true : false)).end()
                        .find('[name="hargahadapjalan"]').each(function() {
                            $(this).val((selectedD.hadapjalan==1) ? selectedD.hargahadapjalan : 0);
                            $(this).attr('readonly', (selectedD.hadapjalan==1) ? false : true);
                        }).end()
                        .find('[id="fasum"]').prop('checked',((selectedD.fasum==1) ? true : false)).end()
                        .find('[name="hargafasum"]').each(function() {
                            $(this).val((selectedD.fasum==1) ? selectedD.hargafasum : 0);
                            $(this).attr('readonly', (selectedD.fasum==1) ? false : true);
                        }).end();
            formPemesanan.find('.change-total').change();
        });

        resetform();
        var table = $('#table_docpemesanan');
        var oTable = table.DataTable({
                "bProcessing": true,
                "bServerSide": true,
                "retrieve": true,
                "paging": false,
                "ordering": false,
                "bInfo": false,
                "bfilter": false,
                "searching": false,
                "ajax": {
                    type: "post",
                    dataType: "json",
                    url: siteurl+"Pemasaran/pemesanan/dokumenpemesanan_list",
                    data: function(d) {
                    	d.noid= formPemesanan.find('#noidpemesanan').val(), 
                    	d.typekonsumen= $('#typekonsumen',formPemesanan).find('option:selected').val()
                    },
                    error: function (xhr, error, thrown) {
                                App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: xhr.responseText,
                                    container: wrapper,
                                    place: 'prepend',
                                    //closeInSeconds: 3 // auto close in 5 seconds
                                });
                            }
                },
                "columns": [
                    { "name": "no"},
                    { "name": "noiddokumen"},
                    { "name": "namadoc"},
                    { "name": "diserahkan"},
                    { "name": "tglpenyerahan"}
                ],
        });

		//Get Dokumen Pemesanan
        $('#typekonsumen').on('change',function() {
            oTable.ajax.reload();
        });

         //changed.bs.select Combao Pola Pembayaran
         formPemesanan.on('change','#polabayar',function() {
            var selectedD = $(this).find('option:selected').val();
            //console.log(selectedD);
            if (selectedD == 0) { //KPR
                    formPemesanan.find('#box-angsuran').hide(); 
                    formPemesanan.find('#box-plafonkpr').show();
                    formPemesanan.find('#plafonkpr').attr("required", 'required');
                    formPemesanan.find('#lamaangsuran').removeAttr("required");
                    formPemesanan.find('#lamaangsuran').removeAttr("min");
                } else { //Tunai Bertahap //Cash Keras
                    formPemesanan.find('#box-angsuran').show(); 
                    formPemesanan.find('#box-plafonkpr').hide();    
                    formPemesanan.find('#lamaangsuran').attr("required", 'required');
                    formPemesanan.find('#lamaangsuran').attr("min", 1);
                    formPemesanan.find('#plafonkpr').removeAttr("required");
                }
        });

        // Tanggal Pemesanan Onchange
        formPemesanan.on('changeDate','#dptglpesanan', function(ev){
            formPemesanan.find('#tgl_pesanan').val(formPemesanan.find('#dptglpesanan').datepicker('getFormattedDate','yyyy-mm-dd'));
        });

        //Reset
        wrapper.on("click",".reset",function(e){    
            e.preventDefault();
            //console.log('reset');
            resetform();
        }); //end of

        //Chek Box change
        formPemesanan.on('click','#redesignbangunan, #tambahkwalitas, #pekerjaantambah',function(){
            var item = this;
            var entry = ["hargaredesign","hargatambahkwalitas","hargapekerjaantambah"];

            if (item.checked) {
                formPemesanan.find("[id='"+entry[item.value-4]+"']").prop("readonly", false);
                formPemesanan.find("[id='"+entry[item.value-4]+"']").attr("required", 'required');
            } else {
                formPemesanan.find("[id='"+entry[item.value-4]+"']").prop("readonly", true);
                formPemesanan.find("[id='"+entry[item.value-4]+"']").val(0);
                formPemesanan.find("[id='"+entry[item.value-4]+"']").removeAttr("required");
            }
        });

		//Form Pemesanan Validation
		formPemesanan.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: true, // do not focus the last invalid input
            rules: {
                hargajual: {required: true},
                namapemesan: {required: true},
                alamatpemesan: {required: true},
                namapasangan: {required: true},
                alamatpasangan: {required: true},
                tglpesanan: {required: true},
                nopesanan: {required: true},
            },
            messages:
            {
                hargajual:{required: "Nomor Kavling Perlu diisi"},
                namapemesan:{required: "Nama Pemesanan harus diisi"},
                alamatpemesan:{required: "Alamat Pemesanan harus diisi"},
                namapasangan:{required: "Nama Pemesanan harus diisi"},
                alamatpasangan:{required: "Alamat Pasangan harus diisi"},
                tglpesanan:{required: "Tanggal Pemesanan harus diisi"},
                nopesanan:{required: "Nomor Pesanan harus diisi"},
                plafonkpr:{required: "Plafon KPR harus diisi"},
                lamaangsuran:{required: "Lama Angsuran harus diisi", min: "Lama Angsuran minimal 1x"}                
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            submitHandler: function(e){
                var tabledoc = $('#table_docpemesanan').dataTable();
                
                // Post Data Form
                var cols = tabledoc.fnSettings().aoColumns,
                    rows = tabledoc.fnGetData();

                var result = $.map(rows, function(row) {
                    var object = {};
                    for (var i=row.length-1; i>=0; i--)
                        // running backwards will overwrite a double property name with the first occurence
                        object[cols[i].name] = row[i]; // maybe use sName, if set
                    return object;
                });

                var detailstr = JSON.stringify(result);
                var data = formPemesanan.serialize()+"&detail="+detailstr; //$('#form_jurnalkb').serializeObject();
                result = undefined;
                cols = undefined;
                rows = undefined;

                //console.log(data);
                //return;

                $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: siteurl+'Pemasaran/pemesanan/save_crud', // ajax source
                        data: data, //{data, dataTable: datatable},
                        error: function (xhr, error, thrown) {
                                    App.alert({
                                        type: 'danger',
                                        icon: 'warning',
                                        message: xhr.responseText,
                                        container: wrapper,
                                        place: 'prepend',
                                        //closeInSeconds: 3 // auto close in 5 seconds
                                    });
                                }
                    }).success(function(response) {
                            if (response['status'] == false) { //error server validation
                            	App.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: 'Error Saving record',
                                    container: wrapper,
                                    place: 'prepend',
                                    closeInSeconds: 3 // auto close in 5 seconds
                                });
                            } else {
	                            App.alert({
                                    type: 'success',
                                    icon: 'info',
                                    message: "Process Complated..",
                                    container: wrapper,
                                    place: 'prepend',
                                    closeInSeconds: 3 // auto close in 5 seconds
                                });
	                            resetform();
	                        }
                        });
                data = undefined;
                detailstr = undefined;
                tabledoc = undefined;

                return false;
            }
        }); //end of validation
        
        
	};

	return {
		init: function() {
			handleForm();
		}
	};
}();

jQuery(document).ready(function() {
    formPemesanan.init();

});