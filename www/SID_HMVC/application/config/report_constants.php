<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('PIMPINAN') OR define('PIMPINAN','I Ketut Mastika');
defined('KEUANGAN') OR define('KEUANGAN','Ni Kadek Kertiasih');
defined('KASIR') OR define('KASIR','Indiantika');

//Keterangan Status Booking
const STATUS_BOOKING = array('Open','Lock','Akad Kredit','Closed','Batal');

//Pola Pembayaran
const POLA_BAYAR = array('KPR','Tunai Keras','Tunai Bertahap');

//Default Title Text Color
defined('TITLE_COLOR') OR define('TITLE_COLOR','navy');

//Default Table Header Fill Color
defined('HEADER_COLOR') OR define('HEADER_COLOR','green-sharp');

//Default Table Header Text Color
defined('HEADER_TEXT_COLOR') OR define('HEADER_TEXT_COLOR','white');

//Default Table Footer Fill Color
defined('FOOTER_COLOR') OR define('FOOTER_COLOR','yellow-light');

//Default Table Header Text Color
defined('FOOTER_TEXT_COLOR') OR define('FOOTER_TEXT_COLOR','dark');

//Default Table Text Color
defined('TEXT_COLOR') OR define('TEXT_COLOR','dark');

//Default Table line Color
defined('LINE_COLOR') OR define('LINE_COLOR','grey');

//Default font Size
defined('FONT_SIZE') OR define('FONT_SIZE',10);