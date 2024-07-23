<script src="<?php echo base_url(); ?>assets/pages/scripts/form-pemesanan.js" type="text/javascript"></script>

<div class="row margin-top-10" id="row_pemesanan">
    <!-- <div class="col-md-12"> -->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">        
                <div class="caption">
                    <i class="fa fa-industry font-dark"></i>
                    <!-- <span class="caption-subject font-dark sbold uppercase">Penerimaan Pembayaran -->
                    <span class="caption-subject sbold">Pemesanan</span>
                    <span class="caption-helper"> New </span>
                    <!-- <em class="hidden-xs small" id="pemesantitle"> | - </em> -->
                </div>
                <div class="actions btn-set">
                    <button type="button" class="btn btn-secondary-outline back hidden" ><i class="fa fa-arrow-left"></i>Back</button>
                    <button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
                    <button type="submit" class="btn btn-success save" form="form_pemesanan"><i class="fa fa-save"></i>Save</button>
                    <button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
                </div>
            </div> <!-- end of portlet-title -->
            <div class="portlet-body">
                <!-- <div id="dataparent" class="hidden"></div> -->
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="msg"> Error msg </span>
                </div>
                <form action="" method="post" role="form" id="form_pemesanan" class="form-horizontal">
                <div class="form-body">
                    <div class="row"> 
                        <div class="form-group"><div class="col-md-6">
                            <label class="col-md-offset-4 col-md-4 col-sm-4 col-xs-4 control-label" for="typekonsumen">Type Konsumen</label>
                            <div class="col-md-4  col-sm-4 col-xs-4">
                                <select name="typekonsumen" id="typekonsumen" class="selectpicker form-control form-group" data-style="btn-primary">
                                    <option value=0>Pegawai</option>
                                    <option value=1>Profesional</option>
                                    <option value=2>Wiraswasta</option>
                                </select> 
                            </div>
                        </div></div>
                        <div class="col-md-6">
                        <!-- <h3 class="form-section">Data Konsumen</h3> -->
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-user font-white"></i><span class="font-white">Data Konsumen</span></div>
                            </div>
                            <div class="portlet-body"> <div class="row">                                                              
                                <div class="col-md-12"><div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-3 control-label text-primary bold"  for="namapemesan">Nama</label>
                                    <div class="col-md-10  col-sm-9 col-xs-9"><div class="input-icon"><i class="fa fa-user"></i><input type="text" name="namapemesan" id="namapemesan" class="form-control input-lg"></div>
                                    </div>
                                </div></div>
                                <div class="col-md-12"><div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-3 control-label text-primary bold" for="alamatpemesan">Alamat</label>
                                    <div class="col-md-10  col-sm-9 col-xs-9"><input type="text" name="alamatpemesan" id="alamatpemesan" class="form-control"></div>
                                </div></div>    
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="rtrwpemesan">RT/RW</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="rtrwpemesan" id="rtrwpemesan" class="form-control"></div>
                                    </div>                                                  
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="kelurahanpemesan">Kelurahan</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="kelurahanpemesan" id="kelurahanpemesan" class="form-control"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="kecamatanpemesan">Kecamatan</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="kecamatanpemesan" id="kecamatanpemesan" class="form-control"></div>
                                    </div>                                                        
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="kabupatenpemesan">Kabupaten</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="kabupatenpemesan" id="kabupatenpemesan" class="form-control"></div>
                                    </div>                                                        
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="telprumahpemesan">Telpon Rumah</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="telprumahpemesan" id="telprumahpemesan" class="form-control"></div>
                                    </div>                                                        
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="telpkantorpemesan">Telp Kantor</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="telpkantorpemesan" id="telpkantorpemesan" class="form-control"></div>
                                    </div>                                                        
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hp1pemesan">HP #1</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hp1pemesan" id="hp1pemesan" class="form-control"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hp2pemesan">HP #2</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hp2pemesan" id="hp2pemesan" class="form-control"></div>
                                    </div>                                                        
                                </div>   
                                </div> <!-- end of row -->
                            </div> <!-- end of portlet-body -->
                        </div> <!-- end of portlet -->

                        <!-- <h3 class="form-section">Data Pasangan</h3> -->
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-user-female font-white"></i><span class="font-white">Data Pasangan</span></div>
                            </div>
                            <div class="portlet-body"><div class="row">
                                <div class="col-md-12"><div class="form-group">                                                       
                                    <label class="col-md-2 col-sm-3 col-xs-3 control-label text-primary bold"  for="namapasangan">Nama</label>
                                    <div class="col-md-10  col-sm-9 col-xs-9"><div class="input-icon"><i class="fa fa-user"></i><input type="text" name="namapasangan" id="namapasangan" class="form-control input-lg"></div>
                                    </div>
                                </div></div>
                                <div class="col-md-12"><div class="form-group">                                                       
                                    <label class="col-md-2 col-sm-3 col-xs-3 control-label text-primary bold" for="alamatpasangan">Alamat</label>
                                    <div class="col-md-10  col-sm-9 col-xs-9"><input type="text" name="alamatpasangan" id="alamatpasangan" class="form-control"></div>
                                </div></div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="rtrwpasangan">RT/RW</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="rtrwpasangan" id="rtrwpasangan" class="form-control"></div>
                                    </div>                                                  
                                    <div class="col-md-6">
                                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="kelurahanpasangan">Kelurahan</label>
                                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="kelurahanpasangan" id="kelurahanpasangan" class="form-control"></div>
                                    </div>                                                        
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="kecamatanpasangan">Kecamatan</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="kecamatanpasangan" id="kecamatanpasangan" class="form-control"></div>
                                    </div>                                                        
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="kabupatenpasangan">Kabupaten</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="kabupatenpasangan" id="kabupatenpasangan" class="form-control"></div>
                                    </div>                                                        
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="telprumahpasangan">Telpon Rumah</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="telprumahpasangan" id="telprumahpasangan" class="form-control"></div>
                                    </div>                                                        
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="telpkantorpasangan">Telp Kantor</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="telpkantorpasangan" id="telpkantorpasangan" class="form-control"></div>
                                    </div>                                                        
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hp1pasangan">HP #1</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hp1pasangan" id="hp1pasangan" class="form-control"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hp2pasangan">HP #2</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hp2pasangan" id="hp2pasangan" class="form-control"></div>
                                    </div>                                                        
                                </div>   
                                </div> <!-- end of row -->
                            </div> <!-- end of portlet-body -->
                        </div> <!-- end of portlet -->
                    </div> <!-- end of col-md-6 -->

                    <div class="col-md-6"> <!-- col-md-6 data pemesanan -->
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption"><i class=" icon-book-open font-white"></i>Data Pemesanan</div>
                                <div class="actions"><label class="bold" id="idpemesanan">-1</label></div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-xs-4 control-label text-right" for="polabayar">Pola Pembayaran</label>
                                        <div class="col-md-4 col-sm-4 col-xs-8">
                                            <select name="polabayar" id="polabayar" class="selectpicker form-control input-small show-tic" data-style="btn-success">
                                                <option value=0 data-value='{"id":"0","value":"KPR"}'>KPR</option>
                                                <option value=1 data-value='{"id":"1","value":"Tunai Keras"}'>Tunai Keras</option>
                                                <option value=2 data-value='{"id":"2","value":"Tunai Bertahap"}'>Tunai Bertahap</option>
                                            </select> 
                                            <div class="form-control-focus"> </div>
                                        </div>
                                        <label class="col-sm-2 col-xs-4 control-label text-right" for="tglpesanan">Tgl. Pemesanan</label>
                                        
                                        <div class="col-sm-4 col-xs-8"> 
                                            <div class="input-group input-medium date date-picker" id = "dptglpesanan">
                                                <input class="form-control" type="text"value="" name="tglpesanan" id="tglpesanan" data-date-start-date="+0d" readonly/>
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                                  
                                </div> <!-- end of row -->
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 col-xs-4 control-label text-right" for="nokavling">No. Kavling</label>
                                        <div class="col-md-4 col-sm-4 col-xs-7">
                                            <select name="nokavling" id="nokavling" class="selectpicker form-control" data-show-subtext="true" data-live-search="false"  data-size="10" >
                                                <?php echo $options ?> 
                                            </select> 
                                            <div class="form-control-focus"> </div>
                                        </div>

                                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-right" for="nopesanan">No. Pesanan</label>
                                        <div class="col-md-3 col-sm-3 col-xs-5">
                                            <input type="text" name="nopesanan" id="nopesanan" class="form-control">
                                            <div class="form-control-focus"> </div>
                                        </div>
                                    </div>                                                       
                                </div>
                                <div class="portlet box grey-steel border-grey-steel">
                                    <div class="portlet-title">
                                        <div class="caption"><span class="font-blue-ebonyclay">Record Detail</span></div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="form-group no-gutter">
                                          <div class="col-sm-4 col-xs-4"><div class="help-block text-right">Luas Bangunan</div><input type="text" disabled class="form-control text-right" placeholder="0" name="luasbangunan" id="luasbangunan"></div>
                                          <div class="col-sm-4 col-xs-4"><div class="help-block text-right">Luas Tanah</div><input type="text" disabled class="form-control text-right" placeholder="0" name="luastanah" id="luastanah"></div>
                                          <div class="col-sm-4  col-xs-4"><div class="help-block text-right bold">Hgr&nbsp;Jual</div><input type="text" class="form-control text-right bold change-total mask_decimal" placeholder="0" name="hargajual" id="hargajual"></div>
                                        </div>
                                        <div class="form-group no-gutter">
                                            <div class="col-sm-offset-4 col-xs-offset-4 col-sm-4 col-xs-4 control-label text-right">Diskon</div>
                                            <div class="col-sm-4 col-xs-4 "><input type="text" class="form-control text-right bold change-total mask_decimal" name="diskon" id="diskon" value="0" placeholder="0"></div>
                                        </div>
                                        <div class="form-group no-gutter">
                                          <div class="col-sm-4 col-xs-4 mod "><input type="text" disabled class="form-control text-right" placeholder="0" name="kelebihantanah" id="kelebihantanah"><div class="help-block text-right">Kelebihan Tanah</div></div>
                                          <div class="col-sm-1 col-xs-4 mod no-padding text-left control-label">X</div>
                                          <div class="col-sm-4 col-xs-4"><input type="text" disabled class="form-control text-right mask_decimal" placeholder="0" name="hargakltm2" id="hargakltm2"><div class="help-block text-right">Harga (m2)</div></div>
                                          <div class="col-sm-4 col-xs-4"><input type="text" class="form-control text-right bold mask_decimal change-total" placeholder="0" name="hargaklt" id="hargaklt"></div>
                                        </div>
                                        <div class="form-group form-md-checkboxes">
                                            <div class="md-checkbox-list">
                                                    <div class="md-checkbox mod ">
                                                        <div class="col-sm-offset-5 col-xs-offset-5 col-sm-3 col-xs-3"> 
                                                            <input type="checkbox" name="check_list[]" value="1" id="sudut" class="md-check" onclick="return false;">
                                                            <label for="sudut"><span class="check"></span><span class="box"></span>Posisi Sudut </label>
                                                        </div>
                                                            <div class="col-sm-4 col-xs-4"> <input type="text" name="hargasudut" id="hargasudut" class="form-control text-right bold mask_decimal change-total" placeholder="0.00" readonly></div>                            
                                                    </div>
                                                    <div class="md-checkbox mod">
                                                        <div class="col-sm-offset-5 col-xs-offset-5 col-sm-3 col-xs-3"> 
                                                            <input type="checkbox" name="check_list[]" value="2" id="hadapjalan" class="md-check" onclick="return false;">
                                                            <label for="hadapjalan" ><span class="check"></span><span class="box"></span>Menghadap Jalan</label>
                                                        </div>
                                                            <div class="col-sm-4 col-xs-4"> <input type="text" name="hargahadapjalan" id="hargahadapjalan" class="form-control text-right bold mask_decimal change-total" placeholder="0.00" readonly></div>                            
                                                    </div>
                                                    <div class="md-checkbox mod">
                                                        <div class="col-sm-offset-5 col-xs-offset-5 col-sm-3 col-xs-3"> 
                                                            <input type="checkbox" name="check_list[]" value="3" id="fasum" class="md-check" onclick="return false;">
                                                            <label for="fasum"><span class="check"></span><span class="box"></span>Hadap Fasum</label>
                                                        </div>
                                                            <div class="col-sm-4 col-xs-4"> <input type="text" name="hargafasum" id="hargafasum" class="form-control text-right bold change-total mask_decimal" placeholder="0.00" readonly></div>                            
                                                    </div>
                                                    <div class="md-checkbox mod">
                                                        <div class="col-sm-offset-5 col-xs-offset-5 col-sm-3 col-xs-3"> 
                                                            <input type="checkbox" name="check_list[]" value="4" id="redesignbangunan" class="md-check">
                                                            <label for="redesignbangunan"><span class="check"></span><span class="box"></span>Redesign Bangunan</label>
                                                        </div>
                                                            <div class="col-sm-4 col-xs-4"> <input type="text" name="hargaredesign" id="hargaredesign" class="form-control text-right bold change-total mask_decimal" placeholder="0.00" readonly></div>                            
                                                    </div>
                                                    <div class="md-checkbox mod">
                                                        <div class="col-sm-offset-5 col-xs-offset-5 col-sm-3 col-xs-3"> 
                                                            <input type="checkbox" name="check_list[]" value="5" id="tambahkwalitas" class="md-check">
                                                            <label for="tambahkwalitas"><span class="check"></span><span class="box"></span>Tambah Kwalitas</label>
                                                        </div>
                                                            <div class="col-sm-4 col-xs-4"> <input type="text" name="hargatambahkwalitas" id="hargatambahkwalitas" class="form-control text-right bold change-total mask_decimal" placeholder="0.00" readonly></div>                            
                                                    </div>
                                                    <div class="md-checkbox mod">
                                                        <div class="col-sm-offset-5 col-xs-offset-5 col-sm-3 col-xs-3"> 
                                                            <input type="checkbox" name="check_list[]" value="6" id="pekerjaantambah" class="md-check">
                                                            <label for="pekerjaantambah"><span class="check"></span><span class="box"></span>Pekerjaan Tambah</label>
                                                        </div>
                                                            <div class="col-sm-4 col-xs-4"> <input type="text" name="hargapekerjaantambah" id="hargapekerjaantambah" class="form-control text-right bold change-total mask_decimal" placeholder="0.00" readonly></div>                            
                                                    </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px dotted #B8B8B8;">
                                        <div class="form-group no-gutter">
                                            <div class="col-sm-offset-4 col-xs-offset-4 col-sm-4 col-xs-4 control-label text-right">TOTAL HARGA</div>
                                            <div class="col-sm-4 col-xs-4"><input type="text" class="form-control text-right bold mask_decimal" placeholder="0" name="totalharga" id="totalharga" readonly></div>
                                        </div>

                                        <div class="form-group no-gutter">
                                            <div class="col-sm-offset-4 col-xs-offset-4 col-sm-4 col-xs-4 control-label text-right">Booking Fee</div>
                                            <div class="col-sm-4 col-xs-4"><input type="text" class="form-control text-right bold mask_decimal" placeholder="0" name="bookingfee" id="bookingfee"></div>
                                        </div>
                                        <div class="form-group no-gutter">
                                            <div class="col-sm-offset-4 col-xs-offset-4 col-sm-4 col-xs-4 control-label text-right">Uang Muka</div>
                                            <div class="col-sm-4 col-xs-4"><input type="text" class="form-control text-right bold mask_decimal change-total" placeholder="0" name="totaluangmuka" id="totaluangmuka"></div>
                                        </div> 
                                        <div class="form-group no-gutter">
                                            <div class="col-sm-offset-4 col-xs-offset-4 col-sm-4 col-xs-4 control-label text-right">Estimasi HPP</div>
                                            <div class="col-sm-4 col-xs-4"><input type="text" class="form-control text-right bold mask_decimal" placeholder="0" name="hpp" id="hpp"></div>
                                        </div> 
                                        <div class="form-group no-gutter" id="box-plafonkpr">
                                            <div class="col-sm-offset-4 col-xs-offset-4 col-sm-4 col-xs-4 control-label text-right">Plafon KPR</div>
                                            <div class="col-sm-4 col-xs-4"><input type="text" class="form-control text-right bold mask_decimal" placeholder="0" name="plafonkpr" id="plafonkpr"></div>
                                        </div>
                                        <div class="form-group no-gutter" id="box-angsuran" style="display:none">
                                            <div class="col-sm-offset-4 col-xs-offset-2 col-sm-4 col-xs-4 control-label text-right">Nilai Angsuran</div>
                                            <div class="col-sm-1 col-xs-2"><input type="text" class="form-control text-right change-total" placeholder="0" name="lamaangsuran" id="lamaangsuran"><div class="help-block text-right">Lama</div></div>
                                          <div class="col-sm-1 col-xs-1 mod no-padding text-left control-label">X</div>
                                            <div class="col-sm-3 mod col-xs-4"><input type="text" class="form-control text-right bold mask_decimal" placeholder="0" name="nilaiangsuran" id="nilaiangsuran" readonly><div class="help-block text-right">Angsuran</div></div>
                                        </div>
                                        <input type="hidden" id="crud" name="crud">
                                        <input type="hidden" name="tgl_pesanan" id="tgl_pesanan"/>
                                        <input type="hidden" id="noidpemesanan" name="noidpemesanan">
                                    </div> <!-- end of portlet-body -->
                                </div> <!-- end of portlet -->
                            </div> <!-- end of portlet-body -->
                        </div> <!-- end of portlet -->
                    </div> <!-- end of col-md -->
                    </div> <!-- end of FORM ROW-->
                    <!-- <div class="row">
                    <div class="col-md-offset-2 col-md-8"> -->
                </div> <!-- End of Form Body -->
                </form>
                <div class="portlet box blue-hoki"> 
                    <div class="portlet-title"><div class="caption"><i class="icon-list"></i>Dokumen Persyaratan</div></div>
                    <div class="portlet-body"> 
                        <table class="table table-striped" id="table_docpemesanan">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No.ID</th>
                                    <th>Nama&nbsp;Dokumen</th>
                                    <th>Sudah&nbsp;diserahkan</th>
                                    <th>Tanggal&nbsp;Penyerahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div> <!-- end of portlet-body -->
            <!-- <div class="portlet-footer pull-right">        
                <div class="actions btn-set">
                    <button type="button" class="btn btn-secondary-outline back" ><i class="fa fa-arrow-left"></i>Back</button>
                    <button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
                    <button type="submit" class="btn btn-success save" form="form_pemesanan"><i class="fa fa-save"></i>Save</button>
                    <button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
                </div>
            </div> -->
        </div> <!-- end of portlet -->
    <!-- </div> --> <!-- end of col-md -->
</div> <!-- end of row -->
<!-- </div> --> <!-- end of view form pemesanan -->




