var FormInputMask = function () {
    
    var handleInputMasks = function () {

        $('.mask_decimal').inputmask("decimal", {
            radixPoint: ".", 
            digits: 0, 
            integerDigits: 13, 
            prefix: "Rp ",
            placeholder: "0.00",
            allowMinus: true,
            autoGroup: true,
            groupSeparator: ",",
            //numericInput: true,
            //groupSize: 3,
            //skipRadixDance: true,
            showMaskOnHover: false,
            showMaskOnFocus: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
            clearMaskOnLostFocus: true
    // onUnMask: function(maskedValue, unmaskedValue) {
    //     var x = unmaskedValue.split(',');
    //     return x[0].replace(/\./g, '') + '.' + x[1];
    // }
        });

        $('.mask_decimal1').inputmask("decimal", {
            radixPoint: ".", 
            digits: 2, 
            rightAlignNumerics: true,
            integerDigits: 13, 
            prefix: "Rp ",
            placeholder: "0.00",
            allowMinus: true,
            autoGroup: true,
            groupSeparator: ",",
            showMaskOnHover: false,
            showMaskOnFocus: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
            clearMaskOnLostFocus: true
        });
        

        $("#mask_date").inputmask("d/m/y", {
            autoUnmask: true
        }); //direct mask        
        $("#mask_date1").inputmask("d/m/y", {
            "placeholder": "*"
        }); //change the placeholder
        $("#mask_date2").inputmask("d/m/y", {
            "placeholder": "dd/mm/yyyy"
        }); //multi-char placeholder
        $("#mask_phone").inputmask("mask", {
            "mask": "(999) 999-9999"
        }); //specifying fn & options
        $("#mask_tin").inputmask({
            "mask": "99-9999999",
            placeholder: "" // remove underscores from the input mask
        }); //specifying options only
        $(".mask_number").inputmask("decimal",{
            //numericInput: true,
            rightAlignNumerics: true,
            digits: 0, 
            integerDigits: 7, 
            radixPoint: ".", 
            placeholder: "0.00",
            allowMinus: true,
            autoGroup: true,
            groupSeparator: ",",
            showMaskOnHover: false,
            showMaskOnFocus: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
           // "mask": "9",            
            //"greedy": false
        }); // ~ mask "9" or mask "99" or ... mask "9999999999"
        // $("#mask_decimal").inputmask('decimal', {
        //     rightAlignNumerics: false
        // }); //disables the right alignment of the decimal input
        $("#mask_currency").inputmask('Rp. 999.999.999,99', {
            numericInput: true
        }); //123456  =>  € ___.__1.234,56

        $("#mask_currency2").inputmask('Rp. 999,999,999.99', {
            numericInput: true,
            rightAlignNumerics: false,
            greedy: false
        }); //123456  =>  € ___.__1.234,56
        $("#mask_ssn").inputmask("999-99-9999", {
            placeholder: " ",
            clearMaskOnLostFocus: true
        }); //default
    }

    var handleIPAddressInput = function () {
        // $('#input_ipv4').ipAddress();
        // $('#input_ipv6').ipAddress({
        //     v: 6
        // });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleInputMasks();
            //handleIPAddressInput();
        }
    };

}();

//if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        FormInputMask.init(); // init metronic core componets
    });
//}