/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function selectKolor(idKoloru)
{
    $('.selectedKolor').toggleClass('selectedKolor'); 
    $("#kolor_"+idKoloru).toggleClass('selectedKolor');  
    
     // alert("z js"+idKoloru);
    $.post("/album/selectkolor/"+idKoloru, function(responseTxt,statusTxt,xhr)
        {           
            //alert(responseTxt);                      
           // $("#kolorGrid").html(responseTxt);
         
        });
}

