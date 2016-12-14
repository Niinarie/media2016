$(document).ready(function() {
  
//Menu animation
$('#navbutton').click(function(){
    $('#rightMenu').slideToggle(400);
    $('#leftMenu').hide();
    
});
  
//show delete-confirmation-box
$('#delete').click(function(){
    $('#deletebox').slideToggle(400);
    $('#deledit').slideToggle(100);
});

//close delete-confirmation-box
$('#dontdelete').click(function(){
   $('#deletebox').slideToggle(400); 
    $('#deledit').slideToggle(100);
});

//toggle editing options for upload
$('#edit').click(function(){
   $('#editbox').slideToggle(400); 
});

//animate login-box in menu and front page     
$("#login").click(function(){
        $("#loginform").slideToggle(400);
    });


//toggle search-box in menu
$("#search").click(function(){
        $("#searchbar").slideToggle(400);
    });
    
//toggle follow-status: changes the look of the button and sends info to php-page which changes the status to database. Checks the title of the link and performs the suitable action, also changes the title so it corresponds to new status
$(document).on('click', '.follow', function(){ 

if($(this).attr('title') == 'Follow'){
   $that = $(this);
   $.post('action_follow.php', {id:$(this).attr('id'), action:'follow'},function(){
    $that.children('img').attr('src','images/unfollow.png');
    $that.attr('title','Unfollow');
   });

}else{
   if($(this).attr('title') == 'Unfollow'){     
    $that = $(this);
    $.post('action_follow.php', {id:$(this).attr('id'), action:'unfollow'},function(){
    $that.attr('title','Follow');
    $that.children('img').attr('src','images/follow.png');
    });

   }}
    
 });
    
//when user clicks 'delete' on post page, performs php to delete corresponding rows from database and redirects user to their profile afterwards
$(document).on('click', '#deletepostbutton', function(){ 
var value = $(this).attr('value');
var user = $(this).attr('name');

   $that = $(this);
   $.post('action_postdelete.php', {id:$(this).attr('value'),user:$(this).attr('name')},function(){
       window.location.href = "profile.php?Id="+user;
   });

 });
    
//same as above, deletes comment from database and reloads the page
$(document).on('click', '.deleteComment', function(){ 
var sender = $(this).attr('value');
var cid = $(this).attr('id');
    
console.log(sender);
   $that = $(this);
   $.post('action_commentdelete.php', {cid:$(this).attr('id'),sender:$(this).attr('value')},function(){
       location.reload();
   });
 });

//same as follow-function, toggles the state of like-button and makes required changes to database without need to refresh page. Also changes the value of likes that is displayed on the page, however it's for user-friendliness only as the new amount of likes might not be correct as it doesn't come straight from the database
$(document).on('click', '.like', function(){
    
$likes = parseInt($(this).attr('value'));

  if($(this).attr('title') == 'Like'){
   $that = $(this);
    $likes = $likes +1;
   $.post('action.php', {pid:$(this).attr('id'), action:'like'},function(){
    $that.children('img').attr('src','images/liked2.png');
    $that.attr('title','Unlike');
    $that.attr('value',$likes);
   });

    $(this).next('.likes').html($likes); 
  }else{
   if($(this).attr('title') == 'Unlike'){     
    if($likes>0){
          $likes = $likes - 1;       
      }

    $that = $(this);
    $.post('action.php', {pid:$(this).attr('id'), action:'unlike'},function(){
     $that.children('img').attr('src','images/liked.png');
     $that.attr('title','Like');
    $that.attr('value',$likes);

    });

  $(this).next('.likes').html($likes); 
   }
  }
    
 });



   
// commenting, saves comment using php page, returns message if commenting was successful or not. We intended the script to append the new comment onto the page but ran out of time, so just simple location reload here
$('#commentBox form').on('submit', function(e){
e.preventDefault();
console.log($pid);
    
    
$.ajax({
  type    : "POST",
  url     : "saveComment.php",
  data    : $(this).serialize(),      
  success : function( response ) {  
    
    alert(response);
    location.reload();
  
  }
});
 
});

 });       


