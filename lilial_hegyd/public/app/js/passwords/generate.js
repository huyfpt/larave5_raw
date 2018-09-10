(function ($) {
    $('a.generate_password').on('click', function(){
        GeneratePassword(8, true, true, true, true);
    })

    function GeneratePassword(length, arg1, arg2, arg3, arg4) {

        var res = '';
        var str='';
        var str1='azertyuiopqsdfghjklmwxcvbn';
        var str2='AZERTYUIOPQSDFGHJKLMWXCVBN';
        var str3='1234567890';
        var str4='!@#$%^&*.,';

        if(arg1){ str=str+str1; }
        if(arg2){ str=str+str2; }
        if(arg3){ str=str+str3; }
        if(arg4){ str=str+str4; }

        for (i=0; i < length; i++) {
            j = getRandomNum(str.length);
            res = res + str.charAt(j);
        }

        $('#passKey').removeClass('hide').html("Veuillez recopier le mot de passe généré  :  <b>" + res + "</b>");
    }


    function getRandomNum(cnt) {
        // between 0 - 1
        var rndNum = Math.random()
        rndNum = parseInt(rndNum * cnt);
        return rndNum;
    }



})(jQuery)