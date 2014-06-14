
<!DOCTYPE html>
<html>
  <head>
    <style>
      #container
      {
        position: relative;
      }

      #left-column
      {
        width: 50%;
        background-color: pink;
      }

      #right-column
      {
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        width: 50%;
        background-color: teal;
      }
    </style>
  </head>
  <body>
    <form action="testjs.php" method ="post">
    <div id="container">
      <div id="left-column">
        <ul>
          <li>Foo</li>
          <li>Bar</li>
          <li>Baz</li>
         </ul>
         <input type="hidden" name="test1" id="test" value="">
         <input type = submit onclick="intialize(<?php echo "4" ;?>)">
      </div>
     
    </div>
    </form>
     <div id="right-column">
        Lorem ipsum  <?php 
if(isset($_POST['test1']))
echo $_POST['test1'];
?>
      </div>
      
<script type="text/javascript">

function intialize(invalue)
{
    
    document.getElementById("test").value = invalue;
}
</script>
      
  </body>
</html>


