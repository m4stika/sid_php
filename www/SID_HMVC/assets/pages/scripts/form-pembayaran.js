var FormPayment = function () {
	
	var handleForm = function() {
        var wrapper = $('#row_pembayaran');
        var wrapperError = wrapper.find('.portlet-body:first');
        var formPembayaran = wrapper.find('#form_pembayaran');
        var rincianPembayaran = formPembayaran.find('#rincianpembayaran');

        var wrapperKwitansi = $('#row_kwitansi');
        var wrapperBatal = $('#row_batal');
        var formBatal = wrapperBatal.find('#form_batal');

        var table = wrapper.find('#table_history_pembayaran');
        var grid = new Datatable();

        //Bank Select Change
        formPembayaran.on('changed.bs.select','#cbbank', function(e, clickedIndex, newValue, oldValue) {
            var abank = $(this).find("option:selected").data('value');
            formPembayaran.find('#accbank').val($(this).val());
        });

        wrapperBatal.draggable({
            handle: ".modal-header"
        });

        
        var urlhref = null;
        var tableLoaded = false;
		

        //cek jika form di panggil dari form yang lain
        if (wrapper.find("#induk").text() == 'browsepemesanan') {
        	wrapper.find('.back').removeClass('hidden'); //aktifkan tombol back
        	urlhref = siteurl+"Pemasaran/pemesanan"; //set url
        }

        wrapper.on('click','.back', function(e) {
        	e.preventDefault();
        	document.location.href=urlhref;
        });
       
         //changed.bs.select Combao No.Pemesanan
        wrapper.on('changed.bs.select','#cbpemesan',function(e, clickedIndex, newValue, oldValue) {
            formPembayaran.trigger('reset');
            var anoid = $(this).val();
            var totalharga = [];

            $.ajax({
            	type: 'post',
            	dataType: 'json',
            	url: siteurl+"Pemasaran/pemesanan/get_record",
					data : {
						noid: anoid,
					}, 
					error: function (xhr, error, thrown) {
								App.alert({
	                                type: 'danger',
	                                icon: 'warning',
	                                message: xhr.responseText,
	                                container: wrapperError,
	                                place: 'prepend',
	                                //closeInSeconds: 3 // auto close in 5 seconds
	                            });
							}
				}).success(function(response) {
					aData = response.data;
					var polabayar = ['KPR','TUNAI KERAS','TUNAI BERTAHAP'];

		            wrapper
			            .find('#namapemesan').text(aData.namapemesan).end()
			            .find('[name="idpemesanan"]').val(aData.noid).end()
			            .find('[id="polabayar"]').text(polabayar[aData.polapembayaran]).end()
			            .find('[id="polapembayaran"]').val(aData.polapembayaran).end()
			            .find('[id="pemesantitle"]').text('| #'+aData.noid+'=>'+aData.namapemesan).end()
			            .find('[id="namapemesan"]').text(aData.namapemesan).end()
			            .find('[id="alamatpemesan"]').text(aData.alamatpemesan).end()
			            .find('[id="telprumahpemesan"]').text(aData.telprumahpemesan).end()
			            .find('[id="namapasangan"]').text(aData.namapasangan).end()
			            .find('[id="alamatpasangan"]').text(aData.alamatpasangan).end()
			            .find('[id="telprumahpasangan"]').text(aData.telprumahpasangan).end()
			            .find('[id="kavling"]').text(aData.idkavling+'|'+aData.typerumah+'|'+aData.keterangan).end()
			            .find('[name="idtyperumah"]').val(aData.idtyperumah).end()
			            .find('[id="hargajual"]').val(aData.hargajual).end()
			            .find('[id="diskon"]').val(aData.diskon).end()
			            .find('[id="hrgbookingfee"]').val(aData.bookingfee).end()
			            .find('[id="hrguangmuka"]').val(aData.totaluangmuka).end()
			            .find('[id="hrgplafonkpr"]').val(aData.plafonkpr).end()
			            .find('[id="bookingfeebyr"]').val(aData.bookingfeebyr).end()
			            .find('[id="bookingfeeonp"]').val(aData.bookingfeeonp).end()
			            .find('[id="uangmukabyr"]').val(aData.lunasuangmuka).end()
			            .find('[id="uangmukaonp"]').val(aData.uangmukaonp).end()
			            .find('[id="hargakltbyr"]').val(aData.hargakltbyr).end()
			            .find('[id="hargakltonp"]').val(aData.hargakltonp).end()
			            .find('[id="hargasudutbyr"]').val(aData.hargasudutbyr).end()
			            .find('[id="hargasudutonp"]').val(aData.hargasudutonp).end()
			            .find('[id="hargahadapjalanbyr"]').val(aData.hargahadapjalanbyr).end()
			            .find('[id="hargahadapjalanonp"]').val(aData.hargahadapjalanonp).end()
			            .find('[id="hargafasumbyr"]').val(aData.hargafasumbyr).end()
			            .find('[id="hargafasumonp"]').val(aData.hargafasumonp).end()
			            .find('[id="hargaredesignbyr"]').val(aData.hargaredesignbyr).end()
			            .find('[id="hargaredesignonp"]').val(aData.hargaredesignonp).end()
			            .find('[id="hargatambahkwbyr"]').val(aData.hargatambahkwbyr).end()
			            .find('[id="hargatambahkwonp"]').val(aData.hargatambahkwonp).end()
			            .find('[id="hargakerjatambahbyr"]').val(aData.hargakerjatambahbyr).end()
			            .find('[id="hargakerjatambahonp"]').val(aData.hargakerjatambahonp).end()
			            .find('[id="totalangsuranbyr"]').val(aData.totalangsuranbyr).end()
			            .find('[id="totalangsuranonp"]').val(aData.totalangsuranonp).end()
			            .find('[id="angke"]').val(aData.bayarangsuranke).end()
			            .find('[id="bookingfeeoff"]').each(function() {
			            		$(this).val(aData.bookingfee);

			            		(parseInt(aData.bookingfee) > 0) ? formPembayaran.find('.blokbookingfee').removeClass('hidden') : formPembayaran.find('.blokbookingfee').addClass('hidden');
			            		formPembayaran.find('#bookingfee').attr('readonly', (parseInt(aData.bookingfee) - (parseInt(aData.bookingfeebyr) + parseInt(aData.bookingfeeonp)) > 0) ? false : true);
			            		formPembayaran.find('#bookingfee').attr({
				            			"max": parseInt(aData.bookingfee) - (parseInt(aData.bookingfeebyr) + parseInt(aData.bookingfeeonp))
				            			});
			            		formPembayaran.find('#bookingfee').val(0);
			            }).end()

			            .find('[id="uangmukaoff"]').each(function() {
			            		$(this).val(aData.totaluangmuka);

			            		(parseInt(aData.totaluangmuka) > 0) ? formPembayaran.find('.blokuangmuka').removeClass('hidden') : formPembayaran.find('.blokuangmuka').addClass('hidden');

			            		formPembayaran.find('#uangmuka').attr('readonly', (parseInt(aData.totaluangmuka) - (parseInt(aData.lunasuangmuka) + parseInt(aData.uangmukaonp)) > 0) ? false : true);
			            		formPembayaran.find('#uangmuka').attr({
				            			"max": parseInt(aData.totaluangmuka) - (parseInt(aData.lunasuangmuka) + parseInt(aData.uangmukaonp))
				            			});
			            		formPembayaran.find('#uangmuka').val(0);
			            }).end()
			            .find('[id="hargakltoff"]').each(function() {
			            		$(this).val(aData.hargaklt);
			            		(parseInt(aData.hargaklt) > 0) ? formPembayaran.find('.blokklt').removeClass('hidden') : formPembayaran.find('.blokklt').addClass('hidden');

			            		formPembayaran.find('#hargaklt').attr('readonly', (parseInt(aData.hargaklt) - (parseInt(aData.hargakltbyr) + parseInt(aData.hargakltonp)) > 0) ? false : true);
			            		formPembayaran.find('#hargaklt').attr({
				            			"max": parseInt(aData.hargaklt) - (parseInt(aData.hargakltbyr) + parseInt(aData.hargakltonp))
				            			});
			            		formPembayaran.find('#hargaklt').val(0);
			            }).end()
			            .find('[id="hargasudutoff"]').each(function() {
			            		$(this).val(aData.hargasudut);
			            		(parseInt(aData.hargasudut) > 0) ? formPembayaran.find('.bloksudut').removeClass('hidden') : formPembayaran.find('.bloksudut').addClass('hidden');
			            		
			            		formPembayaran.find('#hargasudut').attr('readonly', (parseInt(aData.hargasudut) - (parseInt(aData.hargasudutbyr) + parseInt(aData.hargasudutonp)) > 0) ? false : true);
			            		formPembayaran.find('#hargasudut').attr({
				            			"max": parseInt(aData.hargasudut) - (parseInt(aData.hargasudutbyr) + parseInt(aData.hargasudutonp))
				            			});
			            		formPembayaran.find('#hargasudut').val(0);
			            }).end()
			            .find('[id="hargahadapjalanoff"]').each(function() {
			            		$(this).val(aData.hargahadapjalan);
			            		(parseInt(aData.hargahadapjalan) > 0) ? formPembayaran.find('.blokhadapjalan').removeClass('hidden') : formPembayaran.find('.blokhadapjalan').addClass('hidden');
			            		
			            		 formPembayaran.find('#hargahadapjalan').attr('readonly', (parseInt(aData.hargahadapjalan) - (parseInt(aData.hargahadapjalanbyr) + parseInt(aData.hargahadapjalanonp)) > 0) ? false : true);
			            		formPembayaran.find('#hargahadapjalan').attr({
				            			"max": parseInt(aData.hargahadapjalan) - (parseInt(aData.hargahadapjalanbyr) + parseInt(aData.hargahadapjalanonp))
				            			});
			            		formPembayaran.find('#hargahadapjalan').val(0);
			            }).end()
			            .find('[id="hargafasumoff"]').each(function() {
			            		$(this).val(aData.hargafasum);
			            		(parseInt(aData.hargafasum) > 0) ? formPembayaran.find('.blokfasum').removeClass('hidden') : formPembayaran.find('.blokfasum').addClass('hidden');
			            		
			            		formPembayaran.find('#hargafasum').attr('readonly', (parseInt(aData.hargafasum) - (parseInt(aData.hargafasumbyr) + parseInt(aData.hargafasumonp)) > 0) ? false : true);
			            		formPembayaran.find('#hargafasum').attr({
				            			"max": parseInt(aData.hargafasum) - (parseInt(aData.hargafasumbyr) + parseInt(aData.hargafasumonp))
				            			});
			            		formPembayaran.find('#hargafasum').val(0);
			            }).end()
			            .find('[id="hargaredesignoff"]').each(function() {
			            		$(this).val(aData.hargaredesign);

			            		(parseInt(aData.hargaredesign) > 0) ? formPembayaran.find('.blokredesign').removeClass('hidden') : formPembayaran.find('.blokredesign').addClass('hidden');
			            		
			            		formPembayaran.find('#hargaredesign').attr('readonly', (parseInt(aData.hargaredesign) - (parseInt(aData.hargaredesignbyr) + parseInt(aData.hargaredesignonp)) > 0) ? false : true);
			            		formPembayaran.find('#hargaredesign').attr({
				            			"max": parseInt(aData.hargaredesign) - (parseInt(aData.hargaredesignbyr) + parseInt(aData.hargaredesignonp))
				            			});
			            		formPembayaran.find('#hargaredesign').val(0);
			            }).end()
			            .find('[id="hargatambahkwoff"]').each(function() {
			            		$(this).val(aData.hargatambahkwalitas);
			            		(parseInt(aData.hargatambahkwalitas) > 0) ? formPembayaran.find('.bloktambahkw').removeClass('hidden') : formPembayaran.find('.bloktambahkw').addClass('hidden');
			            		
			            		formPembayaran.find('#hargatambahkwalitas').attr('readonly', (parseInt(aData.hargatambahkwalitas) - (parseInt(aData.hargatambahkwbyr) + parseInt(aData.hargatambahkwonp)) > 0) ? false : true);
			            		formPembayaran.find('#hargatambahkwalitas').attr({
				            			"max": parseInt(aData.hargatambahkwalitas) - (parseInt(aData.hargatambahkwbyr) + parseInt(aData.hargatambahkwonp))
				            			});
			            		formPembayaran.find('#hargatambahkwalitas').val(0);
			            }).end()
			            .find('[id="hargakerjatambahoff"]').each(function() {
			            		$(this).val(aData.hargapekerjaantambah);
			            		(parseInt(aData.hargapekerjaantambah) > 0) ? formPembayaran.find('.bloktambahkontruksi').removeClass('hidden') : formPembayaran.find('.bloktambahkontruksi').addClass('hidden');

			            		formPembayaran.find('#hargapekerjaantambah').attr('readonly', (parseInt(aData.hargapekerjaantambah) - (parseInt(aData.hargakerjatambahbyr) + parseInt(aData.hargakerjatambahonp)) > 0) ? false : true);

			            		formPembayaran.find('#hargapekerjaantambah').attr({
				            			"max": parseInt(aData.hargapekerjaantambah) - (parseInt(aData.hargakerjatambahbyr) + parseInt(aData.hargakerjatambahonp))
				            			});
			            		formPembayaran.find('#hargapekerjaantambah').val(0);
			            }).end()
			            .find('[id="totalangsuranoff"]').each(function() {
			            		$(this).val(aData.totalangsuran);
			            		formPembayaran.find('#totalangsuran').attr('readonly', (parseInt(aData.totalangsuran) - (parseInt(aData.totalangsuranbyr) + parseInt(aData.totalangsuranonp)) > 0) ? false : true);
			            		formPembayaran.find('#totalangsuran').attr({
				            			"max": parseInt(aData.totalangsuran) - (parseInt(aData.totalangsuranbyr) + parseInt(aData.totalangsuranonp))
				            			});
			            		formPembayaran.find('#totalangsuran').val(0);
			            }).end();


			            if (aData.polapembayaran == 0) {
			            	formPembayaran.find('.bloktunai').addClass('hidden');formPembayaran.find('.blokkpr').removeClass('hidden');
			            	totalharga.tunggakan = parseInt(aData.bookingfee) + parseInt(aData.totaluangmuka) + parseInt(aData.hargaklt) +
			            							parseInt(aData.hargasudut) + parseInt(aData.hargahadapjalan) + parseInt(aData.hargafasum) + 
			            							parseInt(aData.hargaredesign) + parseInt(aData.hargatambahkwalitas) + parseInt(aData.hargapekerjaantambah);

			            	totalharga.terbayar = parseInt(aData.bookingfeebyr) + parseInt(aData.lunasuangmuka) + parseInt(aData.hargakltbyr) +
			            							parseInt(aData.hargasudutbyr) + parseInt(aData.hargahadapjalanbyr) + parseInt(aData.hargafasumbyr) + 
			            							parseInt(aData.hargaredesignbyr) + parseInt(aData.hargatambahkwbyr) + parseInt(aData.hargakerjatambahbyr);

			            	totalharga.onprocess = parseInt(aData.bookingfeeonp) + parseInt(aData.uangmukaonp) + parseInt(aData.hargakltonp) +
			            							parseInt(aData.hargasudutonp) + parseInt(aData.hargahadapjalanonp) + parseInt(aData.hargafasumonp) + 
			            							parseInt(aData.hargaredesignonp) + parseInt(aData.hargatambahkwonp) + parseInt(aData.hargakerjatambahonp);
			            }
			            else {
			            	formPembayaran.find('.bloktunai').removeClass('hidden');
			            	formPembayaran.find('.blokkpr').addClass('hidden');
			            	totalharga.tunggakan = parseInt(aData.bookingfee) + parseInt(aData.totaluangmuka) + parseInt(aData.totalangsuran);
			            	totalharga.terbayar = parseInt(aData.bookingfeebyr) + parseInt(aData.lunasuangmuka) + parseInt(aData.totalangsuranbyr);
			            	totalharga.onprocess = parseInt(aData.bookingfeeonp) + parseInt(aData.uangmukaonp) + parseInt(aData.totalangsuranonp);
			            }

			            formPembayaran.find('#totaloff').val(totalharga.tunggakan);
			            formPembayaran.find('#totalbyr').val(totalharga.terbayar);
			            formPembayaran.find('#totalonp').val(totalharga.onprocess);

			            var sVal = formPembayaran.find('select[name=cbbank] option:first').val();
			            formPembayaran.find('select[name=cbbank]').val(sVal);
			            formPembayaran.find('#accbank').val(sVal);
			            wrapper.find('.reset').removeAttr('disabled');

			            grid.getDataTable().ajax.reload();
			    });
        });

 		if (formPembayaran.find("#idpemesanan").val() != "" ) {
        	wrapper.find('select[id=cbpemesan]').val(formPembayaran.find("#idpemesanan" ).val());
            wrapper.find("#cbpemesan" ).trigger('changed.bs.select');
        }


		// Tanggal Pembayaran Onchange
		formPembayaran.on('changeDate','#dptglbayar', function(ev){
            formPembayaran.find('#tglpembayaran').val(formPembayaran.find('#dptglbayar').datepicker('getFormattedDate','yyyy-mm-dd'));
        });

		//Calculate Total
        formPembayaran.on('change','.change-total', function() {
        	var polabayar =  formPembayaran.find('#polapembayaran').val();
        	//$('#cbpemesan').find("option:selected").data('value').polapembayaran;
        
            var total;
            if (polabayar == 0) //KPR
            {
            	total = parseInt(rincianpembayaran.find('#bookingfee').val()) + 
            			parseInt(rincianpembayaran.find('#uangmuka').val()) + 
            			parseInt(rincianpembayaran.find('#hargaklt').val()) + 
            			parseInt(rincianpembayaran.find('#hargasudut').val()) + 
            			parseInt(rincianpembayaran.find('#hargahadapjalan').val()) + 
            			parseInt(rincianpembayaran.find('#hargafasum').val()) + 
            			parseInt(rincianpembayaran.find('#hargaredesign').val()) + 
            			parseInt(rincianpembayaran.find('#hargatambahkwalitas').val()) + 
            			parseInt(rincianpembayaran.find('#hargapekerjaantambah').val())
            
            } else  {
            	total = parseInt(rincianpembayaran.find('#bookingfee').val()) + 
            			parseInt(rincianpembayaran.find('#uangmuka').val()) + 
            			parseInt(rincianpembayaran.find('#totalangsuran').val());
            }
            rincianpembayaran.find('#total').val(total);
            (total = 0) ? wrapper.find('.save, .reset').attr('disabled','disabled') : wrapper.find('.save, .reset').removeAttr('disabled');
        });

        wrapper.on("click",".reset",function(e){    
            grid.getDataTable().clear().draw();
        });

        //tab-pane change
        wrapper.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  var activeTab = wrapper.find("ul li.active").attr('id');
		  (activeTab == 'history') ? wrapper.find('.save, .reset').attr('disabled','disabled') : wrapper.find('.save, .reset').removeAttr('disabled');
		});

        wrapper.on("click",".print",function(e){                          
            var activeTab = wrapper.find("ul li.active").attr('id');
            var noid = wrapper.find("#noid").val();
            if (activeTab == 'detil') {
            	if (noid > 0) {handlePrint()};

            } else {            	
            	aData = oTable.row('.selected').data();
            	if (!aData) return false;

            	formPembayaran.find("#noid").val(aData[1]);
            	handlePrint();
            }
            
            function handlePrint() {
            	noid = formPembayaran.find("#noid").val();
            	if (noid <= 0) return false;

            	$.ajax({
	            	url: siteurl+"Pemasaran/pembayaran/print_kwitansi", 
	            	type: 'post',
	            	dataType: 'json',
	            	data: {noid: noid},
	            	error: function (xhr, error, thrown) {									
									App.alert({
		                                type: 'danger',
		                                icon: 'warning',
		                                message: xhr.responseText,
		                                container: wrapperError,
		                                place: 'prepend',
		                                //closeInSeconds: 3 // auto close in 5 seconds
		                            });
							},
	            	success: function(result) { 
							wrapperKwitansi
							.find('[id="nokwitansi"]').text(result.nokwitansi).end()
							.find('[id="tglbayar"]').text(result.tglbayar).end()
							.find('[id="namapemesan"]').text(result.namapemesan).end()
							.find('[id="alamatpemesan"]').text(result.alamatpemesan).end()
							.find('[id="alamatpemesan1"]').text(result.alamatpemesan1).end()
							.find('[id="keterangan"]').text(result.keterangan).end()
							.find('[id="description"]').text(result.description).end()
							.find('[id="totalterbilang"]').text(result.totalterbilang).end()
							.find('[id="totalbayar"]').text(result.totalbayar).end();
							wrapper.hide();
				            wrapperKwitansi.show();
						}
	            });
	        }
        });

        //back
        wrapperKwitansi.on("click",".back",function(e){    
            wrapperKwitansi.hide();
            wrapper.show();
        });

        //Cancel / Back
        // wrapper.on("click",".back",function(e){    
        //     e.preventDefault();
        //     $('#browsepemesanan').slideDown('fast', function(){
        //         $('#row_pembayaran').hide(); 
        //     });
            
        // });

        formPembayaran.validate({
		errorElement: 'span', //default input error message container
	    errorClass: 'help-block', // default input error message class
	    focusInvalid: true, // do not focus the last invalid input
	        rules: {                
	            tglbayar: {
	                required: true
	            },
				nobukti: {
	                required: true
	            },
				keterangan: {
	                required: true
	            },
	            total: { required: true}
	        },
			messages:
			{
				tglbayar:{
	                  required: "Tanggal Pembayran harus diisi"
						},
				bookingfee: {required: "Booking fee harus diisi", max: "Booking fee terlalu kecil"},

				nobukti: "Nomor bukti harus diisi",
				keterangan: "Keterangan harus diisi",
				total: "tidak ada nilai yang di bayar, mohon isi pembayaran",
			},
			highlight: function(element) { // hightlight error inputs
	            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
				//alert("error");
				
	        },
			success: function(label) {
	            label.closest('.form-group').removeClass('has-error');
	            label.remove();						
	        },
			
			submitHandler: function(e){				
				var data = formPembayaran.serialize();
				$.ajax({
						type: 'post',
						dataType: 'json',
						url: siteurl+"Pemasaran/pembayaran/save_payment", 
						data: data,
						error: function (xhr, error, thrown) {
									App.alert({
		                                type: 'danger',
		                                icon: 'warning',
		                                message: xhr.responseText,
		                                container: wrapperError,
		                                place: 'prepend',
		                                //closeInSeconds: 3 // auto close in 5 seconds
		                            });
								}
					}).success(function(response) {
							App.alert({
	                            type: 'success',
	                            icon: 'info',
	                            message: "Process Complated..",
	                            container: wrapperError,
	                            place: 'prepend',
	                            closeInSeconds: 3 // auto close in 5 seconds
	                        });
							wrapper.find("#cbpemesan" ).trigger('changed.bs.select');
							oTable.ajax.reload();
						});
				 return false;						
			}  
		});

		//------------------------------------------------------//
		//------ 		HANDLE HISTORY -------------------------//
		//------------------------------------------------------//
		if (!tableLoaded) {	
			grid.init({
			//oTable = table.DataTable({
				src: table,
				onSuccess: function(grid) {},
				onError: function (grid) {},
				// onDataLoad: function (grid) {
				// 	grid.setAjaxParam("idpemesanan", $('#form_pembayaran #idpemesanan').val());
				// 	console.log('data loading..');
				// },
				loadingMessage: 'loading...',
				dataTable: {
					//destroy: true,
					"dom": "<t>",
					"ordering": false,
					select: true,
					"lengthMenu": [
	                    [10, 20, 50, 100, 150, -1],
	                    [10, 20, 50, 100, 150, "All"] // change per page values here
	                ],
	                "pageLength": 20, // default record count per page
					"ajax": {
						type: "post",
	                    dataType: "json",					
	                    url: siteurl+"Pemasaran/pembayaran/payment_history",
	                    data: function(d) {
	                    	d.idpemesanan = formPembayaran.find('#idpemesanan').val();
	                    },
						error: function (xhr, error, thrown) {
									App.alert({
		                                type: 'danger',
		                                icon: 'warning',
		                                message: xhr.responseText,
		                                container: wrapperError,
		                                place: 'prepend',
		                                //closeInSeconds: 3 // auto close in 5 seconds
		                            });
								},
					},
					"columnDefs": [
		                {
                            "targets": [2],
                            "type" : "date",
                            "className": "dt-head-center",
                            "render": function (data) {
                                if (data !== null) {
                                    var date = new Date(data);
                                    var month = date.getMonth() + 1;
                                    var tanggal = date.getDate();
                                    date = ((tanggal > 9) ? tanggal : "0" + tanggal) + "/" + ((month > 9) ? month : "0" + month) + "/" + date.getFullYear();
                                    return "<div class= date>"+date+"<div>";
                                } else {
                                    return "";
                                }
                            }
                        },
		                {
		                    "targets": [5],
		                    "render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
		                    "className": 'dt-right bold bg-warning',                        
		                    "type": "num"
		                },
		               // { "targets": [1], "visible": false,"searchable": false},
		            ],
		            "footerCallback": function ( row, data, start, end, display ) {
		                var api = this.api();
		     
		                // Total over all pages
		                total = api
		                    .column( 5 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );
		                
		                // Update footer
		                $( api.column( 5 ).footer() ).html(
		                    'Rp. '+ total.format(2, 3, '.', ',')
		                    //pageTotal +' ( $'+ total +' total)'
		                );
		            },
				}
			});
			tableLoaded = true;	
			
		} else {
		 	oTable.ajax.reload();
		}

		var oTable = grid.getDataTable();

		// Tanggal Pembayaran Onchange
		formBatal.on('changeDate','#dptglpembatalan', function(ev){
            formBatal.find('#tglbatal').val(formBatal.find('#dptglpembatalan').datepicker('getFormattedDate','yyyy-mm-dd'));
        });

		wrapper.find('.batal').off('click').on('click',function() {
			var aData = grid.getSelectedRows();				
			if (aData[6] == 'Open') { //Status "Open" bisa di Hapus
				bootbox.confirm( {
	               // size: 'small',
	                closeButton: false,
	                title: 'SID - Delete Record',
	                message: "yakin mau menghapus Record ID #"+aData[1]+" ? ",
	                buttons: {
	                    'confirm': {
	                        label: 'Delete',
	                        className: 'btn-danger'
	                    },
	                    'cancel': {
	                        label: 'Cancel',
	                        className: 'btn-primary'
	                    }
	                },              
	                    
	                callback: function(result) {
	                    if(result) {
	                        $.ajax({
								type: 'post',
								dataType: 'json',
								url: siteurl+"Pemasaran/pembayaran/save_PembatalanKwitansi", 
								data: { noid: aData[1]},
								error: function (xhr, error, thrown) {
											App.alert({
			                                type: 'danger',
			                                icon: 'warning',
			                                message: xhr.responseText,
			                                container: wrapperError,
			                                place: 'prepend',
			                                //closeInSeconds: 3 // auto close in 5 seconds
			                            });
									}
							}).success(function(response) {
									//console.log('hasil', response);
									if (response == false) {
										App.alert({
			                                type: 'danger',
			                                icon: 'warning',
			                                message: "Data Not Found",
			                                container: wrapperError,
			                                place: 'prepend',
			                                //closeInSeconds: 3 // auto close in 5 seconds
			                            });
									} else {
										App.alert({
				                            type: 'success',
				                            icon: 'info',
				                            message: "Record Has been deleted..",
				                            container: wrapperError,
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
	                            message: "Deleting record canceled",
	                            container: wrapperError,
	                            place: 'prepend',
	                            closeInSeconds: 3 // auto close in 5 seconds
	                        });
	                    }
	                }
	            }); 
				return false;
			}

			//lakukan Proses Pembatalan untuk Status "Closed" yang tidak bisa di hapus
			$.ajax({ //Get Data From Server
            	type: 'post',
            	dataType: 'json',
            	url: siteurl+"Pemasaran/pembayaran/kwitansiHeaderDetail",
				data : {noid: aData[1]},
				error: function (xhr, error, thrown) {
						App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: xhr.responseText,
                            container: wrapperError,
                            place: 'prepend',
                            //closeInSeconds: 3 // auto close in 5 seconds
                        });
					}
			}).success(function(response) { 
				LockBatal = response.kwitansiHeader.statustransaksi > 1 || response.kwitansiHeader.statusbatal == 1;
				if (LockBatal) {
					App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: 'Kwitansi tidak bisa di batalkan',
                            container: wrapperError,
                            place: 'prepend',
                            //closeInSeconds: 3 // auto close in 5 seconds
                        });
				} else {
					showformbatal(response);
				}
			});

			function showformbatal(data) {
				formBatal.trigger('reset');
				clearValidation('#form_batal');
				wrapperBatal
					.find('[id="noid"]').val(data.kwitansiHeader.noid).end()
					.find('[id="idpemesanan"]').val(data.kwitansiHeader.idpemesanan).end()
					.find('[id="kodeupdated"]').val(data.kwitansiHeader.kodeupdated).end()
					.find('[id="statusbatal"]').val(data.kwitansiHeader.statusbatal).end()
					.find('[id="statustransaksi"]').val(data.kwitansiHeader.statustransaksi).end()
					.find('[id="totalbayar"]').val(data.kwitansiHeader.totalbayar).end()
					.find('[id="nokwitansi"]').text(data.kwitansiHeader.nokwitansi).end()
					.find('[id="tglkwitansi"]').text(data.kwitansiHeader.tglkwitansi).end()
					.find('[id="nopesanan"]').text(data.kwitansiHeader.nopesanan).end()
					.find('[id="typerumah"]').text(data.kwitansiHeader.typerumah).end()
					.find('[id="totaltransaksi"]').text(data.kwitansiHeader.totalbyr).end()
					$('#table_rinciankwitansi').dataTable({
						"dom": "<t>",
						"ordering": false,
						destroy: true,
						data: data.kwitansiDetail,
						"columnDefs": [
			                {
			                    "targets": [3],
			                    "render": $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ' ),
			                    "className": 'dt-right bold',                        
			                    "type": "num"
			                },
			               // { "targets": [1], "visible": false,"searchable": false},
			            ],
			            "footerCallback": function ( row, data, start, end, display ) {
			                var api = this.api();
			     
			                // Total over all pages
			                total = api
			                    .column( 3 )
			                    .data()
			                    .reduce( function (a, b) {
			                        return intVal(a) + intVal(b);
			                    }, 0 );
			                
			                // Update footer
			                $( api.column( 3 ).footer() ).html(
			                    'Rp. '+ total.format(2, 3, '.', ',')
			                );
			            },
					});
				wrapperBatal.modal({backdrop: 'static', keyboard: false, show: true});
			}
			
			
		});

		formBatal.validate({
		errorElement: 'span', //default input error message container
	    errorClass: 'help-block', // default input error message class
	    focusInvalid: true, // do not focus the last invalid input
	        rules: {                
	            tglpembatalan: {
	                required: true
	            },
				cbbankout: {
	                required: true
	            },
				alasanbatal: {
	                required: true
	            },
	            //total: { required: true}
	        },
			messages:
			{
				tglpembatalan:{
	                  required: "Tanggal Batal harus diisi"
						},
				cbbankout: "Bank Pengeluaran harus diisi",
				alasanbatal: "Alasan batal harus diisi",
				//total: "tidak ada nilai yang di bayar, mohon isi pembayaran",
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
						url: siteurl+"Pemasaran/pembayaran/save_PembatalanKwitansi", 
						data: data,
						error: function (xhr, error, thrown) {
									App.alert({
		                                type: 'danger',
		                                icon: 'warning',
		                                message: xhr.responseText,
		                                container: wrapperError,
		                                place: 'prepend',
		                                //closeInSeconds: 3 // auto close in 5 seconds
		                            });
								}
					}).success(function(response) {
							oTable.ajax.reload();
						});
				 wrapperBatal.modal('hide');
				 return false;
			}  
		});
	};

	return {
		init: function() {
			handleForm();
		}
	};
}();


jQuery(document).ready(function() {
	FormPayment.init();
});