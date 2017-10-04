/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('.waslmenu a').on('click',function(e){

    var name = $(this).attr("href");
    if($(name).hasClass('in')){
        e.stopPropagation();
    }
    e.preventDefault();
    // You can also add preventDefault to remove the anchor behavior that makes
    // the page jump
    // e.preventDefault();
});

$('hr').hide();



//$('.panel-heading a').on('click',function(e){
//    if($(this).parents('.panel').children('.panel-collapse').hasClass('in')){
//        e.stopPropagation();
//    }
//    // You can also add preventDefault to remove the anchor behavior that makes
//    // the page jump
//    // e.preventDefault();
//});


//
//function selectedRow(idRoli)
//{           //alert(idAlbumu);  
//    
//    $('.selectedWaslRow').toggleClass('selectedWaslRow'); 
//    $("#role_"+idRoli).toggleClass('selectedWaslRow');    
//    
//     $.post("/admin/selectRole/"+idRoli, function(responseTxt,statusTxt,xhr)
//        {     //    alert(idAlbumu);               
//            //getKoloryGrid();
//           
//        });
//}

//function selectedRow(Rowid)
//{       
//    var menu='user';
//      $.post("/admin/getselectedmenu", function(responseTxt,statusTxt,xhr)
//        {   
//           menu = responseTxt.menu;
//           
//        //alert(responseTxt.menu);
//        //alert("#"+menu+"_"+Rowid);
//        
//            //$('.selectedWaslRow').toggleClass('selectedWaslRow'); 
//                  $("[id^='"+menu+"_'].selectedWaslRow").toggleClass('selectedWaslRow');
//            $("#"+menu+"_"+Rowid).toggleClass('selectedWaslRow');    
//
//             $.post("/admin/selectRow/"+Rowid, function(responseTxt,statusTxt,xhr)
//                {     //    alert(idAlbumu);               
//                    //getKoloryGrid();
//                    
//
//                });
//           
//           
//           
//        });           
//}


$('body').on('click','.waslrow',function(){
    
    //alert($(this).attr('id'));

            var rowid = $(this).attr('id');
            var menu = rowid.split('_')[0];
            
                  $("[id^='"+menu+"_'].selectedWaslRow").toggleClass('selectedWaslRow');
            $("#"+rowid).toggleClass('selectedWaslRow');    

             $.post("/admin/selectRow/"+rowid, function(responseTxt,statusTxt,xhr)
                {     //    alert(idAlbumu);               
                    //getKoloryGrid();
                    

                });
         
});


//okno modalne
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
     $("#permissionsBtnModal").click(function(){
        $("#permissionsModal").modal();
    });
});





function selectAdminMenu(pozycja){
    $.post("/admin/selectAdminMenu/"+pozycja, function(responseTxt,statusTxt,xhr)
        {         //alert(responseTxt);               
            //getKoloryGrid();
           
        });
}



function getUserRoles(Userid)
{
     $.post("/admin/getuserroles/"+Userid, function(responseTxt,statusTxt,xhr)
                {         //alert(responseTxt);               
                    //getKoloryGrid();
                            //alert(Userid);
                        $("#userroles").html(responseTxt);
                });           
}
function saveUsersRole()
{
   var roles = $( "#sel1" ).val();

          $.post("/admin/adduserrole/"+roles, function(responseTxt,statusTxt,xhr)
          {
                  getUserRoles(responseTxt.response);
          });    
}
function removeUserRole()
{
          $.post("/admin/deleteuserrole/0", function(responseTxt,statusTxt,xhr)
          {           
                  getUserRoles(responseTxt.response);
          }); 
}

function getRolesPermissions(Roleid)
{
     $.post("/admin/getrolespermissions/"+Roleid, function(responseTxt,statusTxt,xhr)
                {         //alert(responseTxt);               
                    //getKoloryGrid();
                           // alert(Roleid);
                        $("#rolespermissions").html(responseTxt);
                });           
}

function saveRolesPermission()
{
    var permissions = $("#permissionsSelector").val();
     //alert(permissions);
      $.post("/admin/addrolepermission/"+permissions, function(responseTxt,statusTxt,xhr)
          {
              //alert(responseTxt.response);
                  getRolesPermissions(responseTxt.response);
                  
          });  
   
}

function removeRolesPermission()
{
     $.post("/admin/deleterolepermission/0", function(responseTxt,statusTxt,xhr)
          {         //  alert(responseTxt.response);
                  getRolesPermissions(responseTxt.response);
          }); 
}
