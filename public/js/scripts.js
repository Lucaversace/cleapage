var ajaxloading = false;
$('div#error').hide();

function countOcc(){
    if($('#spin') != ''){
        let spinForm = $('#spin').val();
        const regex = /\{([^{}]*)\}/gi ;
        let found = spinForm.match(regex);
        if (found == null || found == 1) {
            $('#nbspun').attr("value", "0");
        }else{
        let tab = [];
        for (let i = 0; i < found.length; i++) {
            const element = found[i];
            let wordSep = element.split('|');
            numWord = wordSep.length;
            tab.push(numWord);
        }
        var prem = tab[0]; 
        for (let i = 1; i < tab.length; i++) {
            const element = tab[i];
            var result = prem *= element;
        }
        let valeur = result.toString();
        $('#nbspun').attr("value", valeur);
        }
    }
}

function checkSimilarity() {  
    $('#similaritymsg').hide();
    var spin = $.trim($('textarea#spin').val());
    if(spin == '') {
        var error = 'Vous devez saisir un spinning-content pour vérifier la similarité';
        $('#error').html(error).show();
        
    } else if (!ajaxloading) {
        $(".spinning").addClass('loading');
        ajaxloading = true;
        var values = $('#formspin').serialize();
        $.ajax({
            url: "../app/ajax/check_similarity.php",
            type: "POST",
            data: values,
            success: function(data){                    
               $('#similaritymsg').html(data).show();
                
            },
            error:function(){
                $('#error').html('Erreur lors de la vérification de similarité.').show();                                 
            },
            complete:function() {
                ajaxloading = false;
                $(".spinning").removeClass('loading');
            } 
        }); 
    }
    if (spin != '') {
        $('#error').hide();
    }
}
function spinPages() {
    $('#spingpagesmsg').hide();
    $('#similaritymsg').hide();
    $('#linkDownload').hide();
    var sitename = $('#nameSite').val();
    var spin = $.trim($('textarea#spin').val());
    var keywords = $.trim($('textarea#keywords').val());
    var error = '';
    if(spin == '') {
        error += 'Vous devez saisir un spinning-content pour générer les pages. <br>';            
    }
    if(keywords == '') {
        error += 'Vous devez saisir au moins un mot clé. <br>';            
    }
    if (sitename == '') {
        error += 'Saisissez un nom de site.'
    }
    if(error != '') {
        $('#error').html(error).show();
    }
    else if (!ajaxloading && sitename != '' && error == '' && keywords != '' && spin != '') {
        $('#error').hide();
        $(".spinning").addClass('loading');
        ajaxloading = true;
        var values = $('#formspin').serialize();
        $.ajax({
            url: "../app/ajax/generate.php",
            type: "POST",
            data: values,
            success: function(data){    
                    $('#spingpagesmsg').html(data).show();
                    $('#dll').attr('href', `../download/${sitename}`);

            },
            error:function(){
                $('#error').html('Erreur lors de la génération des pages.').show();                                 
            },
            complete:function() {
                ajaxloading = false;
                $(".spinning").removeClass('loading');
            }
        }); 
    }
}

function downloadPage(){
    if(typeof $('a#linkDownload') != 'undefined') {
        console.log("ça marche bijou");
        $('a#linkDownload').click();
    }
}