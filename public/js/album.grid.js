/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->redirect()->toRoute('album', ['action' => 'index']);
//$this->url('album', ['action' => 'edit', 'id' => $album->id])

function getKoloryGrid()
{
    $.post("/album/getkolorgrid/1", function(responseTxt,statusTxt,xhr)
        {           
            //alert(responseTxt);                      
            $("#kolorGrid").html(responseTxt);
        });
}


function selectedRow(idAlbumu)
{           //alert(idAlbumu);  
    
    $('.selectedAlbum').toggleClass('selectedAlbum'); 
    $("#album_"+idAlbumu).toggleClass('selectedAlbum');    
    
     $.post("/album/selectAlbum/"+idAlbumu, function(responseTxt,statusTxt,xhr)
        {     //    alert(idAlbumu);               
            getKoloryGrid();
           
        });
}

function getKolorPage(pageNumber)
{
    $.post("/album/getkolorgrid?page="+pageNumber, function(responseTxt,statusTxt,xhr)
        {           
            //alert(responseTxt);                      
            $("#kolorGrid").html(responseTxt);
        });
}
