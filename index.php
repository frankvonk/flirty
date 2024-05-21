<!DOCTYPE html>
<html>

<head>
   <!--
  <meta http-equiv="refresh" content="2">
  -->
  <meta charset=utf-8>
  <title>Sun Gym</title>

  <link rel="shortcut icon" type="image/x-icon" href="./assets/icons/favicon7.ico" />
  <link href='https://fonts.googleapis.com/css?family=Allerta' rel='stylesheet'>
  <link href='stylesheet.css' rel='stylesheet'>
  <link href='stylesheet_black.css' rel='stylesheet'>
  <link href='stylesheet_the-white-lotus.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="./config.js"></script>

</head>

<!--
  <body id='body' class="body__oppenheimer">
  -->

<body id='body'>
  <div class="lockOverlay" id="lockOverlay"></div>

<!-- This is where title will be displayed -->
<div id=listtitles></div>



  <div class="responsive-design-assist_parent" style="display:none">
    <p class="responsive-design-assist mobile">MOBILE</p>
    <p class="responsive-design-assist tablet">TABLET</p>
    <p class="responsive-design-assist desktop">DESKTOP</p>
  </div>


  <div id="saving-spinner_parent" class="saving-spinner_parent">
    <p id="saving-spinner" class="saving-spinner" >Saving</p>
  </div>

  <div id="retrieving-data-spinner"
    class="retrieving-data-spinner"
  >
    <p>
      Getting your precious data for you!
    </p>
  </div>








  


  <div id="headers-dumpster">

    <div style="display: none;" class="logo-header">
      <p>BioRobot</p>
    </div>

    <div id="logo-header__sun-gym" class="logo-header logo-header__sun-gym">
      <table class="logo-header__sun-gym-inner">
        <tr>
          <td class="td-line1">
            <div class="line1"></div>
          </td>
          <td rowspan="2">
            <div class="logo-header__sun-gym-image">
              <span class="sun">SUN</span>
              <span class="gym">GYM</span>
          </td>
          <td class="td-line3">
            <div class="line3"></div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="line2"></div>
          </td>
          <td>
            <div class="line4"></div>
          </td>
        </tr>
      </table>
    </div>

    <div class="logo-header logo-header__the-visual-dome">
      <p>The Visual Dome</p>
    </div>
    <!--
    <div class="logo-header__the-visual-dome2">
      <h1>The Visual Dome</h1>
    </div>
    -->
    
  </div>




    <div id="action-bar" class="action-bar">
      <!-- <h3 id="displayBioRobot" class="biorobot-title">
        Биоробот делать / BioRobot ToDo 
      </h3> -->
      <!-- <div class='btnSubHeader' id="deleteDB" onclick="resetDataBase()">
        DB RESET
      </div> -->
      <button class='action-bar_button' id="importDB" onclick=importDataBase()>
        In
      </button>
      <button class='action-bar_button' id="exportDB" onclick=exportDataBase()>
        Out
      </button>
      <button class='action-bar_button' id="bin" onclick=renderTasksInBin()>
        Bin
      </button>
      <button class='action-bar_button' id="history" onclick=renderTasksInHistory()>
        Done
      </button>
      <button class='action-bar_button' onclick=toggleDisplayOfAllCategoryTasks()>
        Toggle
      </button> 
      <div class='action-bar_item'>
        <div class="counterTasks" id="counterTasks">
        </div>
      </div>

      <canvas id="signature" class="signature"></canvas>
      <!-- <h4 class="hcBlack">Hide</h4> -->
    </div>





    <!-- Start Modal for general usage -->
    <table class="modal" id="modal">
    </table>
    <!-- End Modal for general usage -->

   <!-- Start Toast for general usage -->
   <table class="toast" id="toast">
    </table>
    <!-- End Toast for general usage -->















    <div id="categoryContainer" class="categoryContainer">

      <div class="flow createNewTaskGrid" id="createNewTaskGrid">
        <!-- 
          <h3 class="create-new-task">Create new task</h3>
        -->

        <!-- 
          <tr>
            <td class="belongsTo" colspan="2">Belongs to category:</td>
          </tr>
        -->

        <div id="newTaskCategoryGrid"
          class="newTaskCategoryGrid">
        </div>
         
      
        <div class="newTaskTitleInputParent">
          <div class="newTaskTitleInputLabel">Title:</div>
          <textarea class="newTaskTitleTextArea" 
            type='text'
            id="newTaskTitleTextArea"
            placeholder="Write title here"></textarea>
          <button class="new-task_submit" id="submit">
            Submit
          </button>
        </div>

      
      
      
    
        <div class="default-order-new-task_parent">
          <button id="btnSetTaskFirst" class='default-order-new-task-first default-order-new-task'>
            Set First
          </button>
          <button id="btnSetTaskLast" class='default-order-new-task-last default-order-new-task'>
            Set Last
          </button>
        </div>

        <div
          class="new-cat_parent"
        >
          <div 
            class="new-cat_label"
          >
            Create new Category
          </div>
          <input class="new-cat_input"
              type='text'
              id="newCategoryInput"
              maxlength="40"
              placeholder="...">
          <button class="new-cat_submit" 
            onclick="createNewCategory()"
            id="createNewCategory"
          >
            Submit
          </button>  
        </div>

      </div>
    </div>








    <footer class="">
      <div class="top">
        <div class="createdBy">Created and hosted by
          <a target="blank" href="http://www.frankvonk.be/">
            www.frankvonk.be
          </a>
        </div>
        <button id="settings-button"
          class="settings-button"
          onclick="openSettingsMenu()"
        >⚙️</button>
        
      </div>
      <div class="bottom">
        <p>Select a Styling Theme</p>
        <button class="css-theme-btn css-theme-btn__sun-gym" id="css-theme-btn__sun-gym"
          onclick="changeCSSTheme('sun-gym')">
          SUN GYM
        </button>
        <button class="css-theme-btn css-theme-btn__black" id="css-theme-btn__black"
          onclick="changeCSSTheme('black')">
          Black
        </button>
        <button class="css-theme-btn css-theme-btn__corbusier" id="css-theme-btn__corbusier"
          onclick="changeCSSTheme('corbusier')">
          Corbusier
        </button>
        <button class="css-theme-btn css-theme-btn__the-white-lotus" id="css-theme-btn__the-white-lotus"
          onclick="changeCSSTheme('the-white-lotus')">
          The White Lotus 🪷
        </button>        <!-- <button class="css-theme-btn css-theme-btn__spirit-animal" id="css-theme-btn__spirit-animal"
          onclick="changeCSSTheme('spirit-animal')">
          Spirit Animal
        </button> -->
     
        <!-- <button class="css-theme-btn css-theme-btn__the-visual-dome" id="css-theme-btn__the-visual-dome"
          onclick="changeCSSTheme('the-visual-dome')">
          The Visual Dome
        </button> -->
        <!-- <button class="css-theme-btn css-theme-btn__oppenheimer" id="css-theme-btn__oppenheimer"
          onclick="changeCSSTheme('oppenheimer')">
          Oppenheimer
        </button> -->
        <!-- <button class="css-theme-btn css-theme-btn__mac-os" id="css-theme-btn__mac-os"
          onclick="changeCSSTheme('mac-os')">
          Mac OS
        </button> -->
        <!-- <button class="css-theme-btn css-theme-btn__lebowski" id="css-theme-btn__lebowski"
          onclick="changeCSSTheme('lebowski')">
          Lebowski
        </button> -->
        <button class="css-theme-btn css-theme-btn__wireframe" id="css-theme-btn__wireframe"
          onclick="changeCSSTheme('wireframe')">
          Wireframe
        </button>    
        <!-- <button class="css-theme-btn css-theme-btn__bender" id="css-theme-btn__bender"
          onclick="changeCSSTheme('bender')">
          Bender
        </button> -->
        <button class="css-theme-btn css-theme-btn__vaporwave" id="css-theme-btn__vaporwave"
          onclick="changeCSSTheme('vaporwave')">
          Vaporwave
        </button>
        <button class="css-theme-btn css-theme-btn__synthax" id="css-theme-btn__synthax"
          onclick="changeCSSTheme('synthax')">
          Synthax
        </button>   
        <!-- <button class="css-theme-btn css-theme-btn__pastel" id="css-theme-btn__paster"
          onclick="changeCSSTheme('pastel')">
          Pastel
        </button> -->
      </div>
    </footer>




    <?php include 'appBioRobotToDo.php'; ?>




</body>
<script src="signature_canvas.js"></script>

<!-- <script src="checknewpathFRANK_____react-background-animation/three.r134.min.js"></script>
<script src="./react-background-animation/vanta.dots.min.js"></script>
<script src="./react-background-animation/vanta.halo.min.js"></script>
<script src="./react-background-animation/vanta.fog.min.js"></script>
<script src="./react-background-animation/vanta.clouds.min.js"></script>
<script src="./react-background-animation/vanta.waves.min.js"></script> -->
<script>
// VANTA.DOTS({
//   el: "html",
//   mouseControls: true,
//   touchControls: true,
//   gyroControls: false,
//   minHeight: 200.00,
//   minWidth: 200.00,
//   scale: 1.00,
//   scaleMobile: 1.00
// })
// VANTA.HALO({
//   el: "html",
//   mouseControls: true,
//   touchControls: true,
//   gyroControls: false,
//   minHeight: 2000.00,
  
//   minWidth: 200.00
// })

// VANTA.FOG({
//   el: "html",
//   mouseControls: true,
//   touchControls: true,
//   gyroControls: false,
//   minHeight: 200.00,
//   minWidth: 200.00,
//   highlightColor: 0xee94ff,
//   midtoneColor: 0xff94c3,
//   lowlightColor: 0x80b0ff,
//   baseColor: 0xffffff,
//   blurFactor: 0.24
// })
// VANTA.CLOUDS({
//   el: "html",
//   mouseControls: true,
//   touchControls: true,
//   gyroControls: false,
//   minHeight: 200.00,
//   minWidth: 200.00,
//   skyColor: 0xa5aff0,
//   cloudColor: 0xe0b9e6,
//   cloudShadowColor: 0xff3ce5,
//   sunColor: 0xfff9a0
// })

// VANTA.WAVES({
//   el: "html",
//   mouseControls: true,
//   touchControls: true,
//   gyroControls: false,
//   minHeight: 200.00,
//   minWidth: 200.00,
//   scale: 1.00,
//   scaleMobile: 1.00,
//   color: 0xf082a5,
//   shininess: 10.00,
//   waveHeight: 10.00,
//   waveSpeed: 0.90,
//   zoom: 0.65
// })



// let els = document.getElementsByTagName('canvas')
// setTimeout(() => {
// // console.log(els[els.length-1])
// // els[els.length-1].style.border = '1px solid red'
// // els[els.length-1].style.height = '300vh'
// // els[els.length-1].style.width = '300vw'
// }, 3000);

let logo_header__sun_gym =document.getElementById('logo-header__sun-gym');
logo_header__sun_gym.onclick = () => logo_header__sun_gym.remove()

</script>
</html>
