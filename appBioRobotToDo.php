<script>

const l = (one, two, three) => {
  if (three) {
    console.log(one, two, three)
  } else if (two) {
    console.log(one, two)
  } else {
    console.log(one)
  }
}
    
document.addEventListener("visibilitychange", () => {
  if (!document.hidden) {
    location.reload();
  } 
});



// Leaving this in the url prevents sending the form
if (window.location.href.includes('?action=sendValue')) {
  // window.location.href = window.location.href.replace('?action=sendValue', '')
}

const retrievingDataSpinner = document.getElementById("retrieving-data-spinner")
const savingSpinnerParent =document.getElementById('saving-spinner_parent')
const savingSpinner = document.getElementById('saving-spinner');
const createNewTaskGrid = document.getElementById('createNewTaskGrid');
const newTaskCategoryGrid = document.getElementById('newTaskCategoryGrid');
const newCategoryInput = document.getElementById('newCategoryInput');
const newTaskTitleTextArea = document.getElementById('newTaskTitleTextArea');

const btnSetTaskFirst = document.getElementById('btnSetTaskFirst');
const btnSetTaskLast = document.getElementById('btnSetTaskLast');

const errSelectTitle = document.getElementById('errSelectTitle');

const deleteDB = document.getElementById('deleteDB');
const btnBin = document.getElementById('bin');
const btnImport = document.getElementById('importDB');
const submit = document.getElementById('submit');
submit.addEventListener('click', () => submitTask())

let newTaskCategory = "";

const lockOverlay = document.getElementById('lockOverlay')
const modal = document.getElementById("modal");
const toast = document.getElementById("toast");





// Handle the buttons to change the CSS theme
const changeCSSTheme = (theme) => {
  body.className = "body__" + theme; 
  document.getElementById("css-theme-btn__" + theme).className = "css-theme-btn css-theme-btn__active " + "css-theme-btn" + theme;
  // TODO remove .css-theme-btn__active from other elements before adding this one
 
  localStorage['THEME'] = theme;

   if (theme == 'wireframe') {
    // localStorage.removeItem('THEME')
  } else {
    // localStorage['THEME'] = theme;
  }

  const signature = document.getElementById('signature');
  if (signature) {
    if (typeof fnLogo !== "undefined") {
      fnLogo();
    }
  }
}


// On statup
if (localStorage['THEME']) {
  changeCSSTheme(localStorage['THEME']);
} else {
  // Set default theme
  changeCSSTheme('sun-gym')
}


/*
// Version which has to include dbBioRobot.js
// Check if localStorage DB exists, otherwise use hardcoded DB
function getDataBase() {
  if(!window.localStorage['BIOROBOT'] || window.localStorage['BIOROBOT'] == "") {
    console.log('no db found, setting default DB');
    window.localStorage['BIOROBOT'] = JSON.stringify(dbBioRobot);
  } else {
    dbBioRobot = JSON.parse(window.localStorage['BIOROBOT']);
    console.log('found db =', dbBioRobot);
  }
}
*/


// Default DataBase
let dbBioRobot = {
	"categories": [
    {
			"id": "General",
			"description": "General",
			"displayContent": true
		},
		{
			"id": "uid1609847627878",
			"description": "Example",
			"displayContent": true
		},
		{
			"id": "uid4355215353454",
			"description": "Work",
			"displayContent": false
		}
	],
	"tasksToBeExecuted": [
    {
			"title": "Demo",
			"uid": "uid1610722542572",
			"category": "General"
		},
		{
			"title": "Administration",
			"uid": "uid1609605848990",
			"category": "General"
		},
		{
			"title": "Drink Coffee",
			"uid": "uid1608751329598",
			"category": "General"
		},
		{
			"title": "ticket research",
			"uid": "uid1608751329598445",
			"category": "uid4355215353454"
		},
		{
			"title": "this is a testcard",
			"uid": "uid1608751329sfdgcv598445",
			"category": "uid1609847627878"
		}
	],
	"tasksHistory": [],
	"tasksDeleted": []
}




/*
'1111011 100010 1100011 1100001 1110100 1100101 1100111 1101111 1110010 1101001 1100101 1110011 100010 111010 1011011 1111011 100010 1101001 1100100 100010 111010 100010 1000111 1100101 1101110 1100101 1110010 1100001 1101100 100010 101100 100010 1100100 1100101 1110011 1100011 1110010 1101001 1110000 1110100 1101001 1101111 1101110 100010 111010 100010 1000111 1100101 1101110 1100101 1110010 1100001 1101100 100010 101100 100010 1100100 1101001 1110011 1110000 1101100 1100001 1111001 1000011 1101111 1101110 1110100 1100101 1101110 1110100 100010 111010 1110100 1110010 1110101 1100101 101100 100010 1110100 1101001 1101101 1100101 1000010 1101100 1101111 1100011 1101011 1110011 100010 111010 1111011 100010 1110100 1101111 1100111 1100111 1101100 1100101 100010 111010 1100110 1100001 1101100 1110011 1100101 101100 100010 1110011 1110100 1100001 1110010 1110100 1010100 1101001 1101101 1100101 100010 111010 1101110 1110101 1101100 1101100 1111101 1111101 1011101 101100 100010 1110100 1100001 1110011 1101011 1110011 1010100 1101111 1000010 1100101 1000101 1111000 1100101 1100011 1110101 1110100 1100101 1100100 100010 111010 1011011 1111011 100010 1110100 1101001 1110100 1101100 1100101 100010 111010 100010 1110000 1100001 1110011 1110100 1100101 1100100 100010 101100 100010 1110101 1101001 1100100 100010 111010 100010 1110101 1101001 1100100 110001 110110 110001 110000 110111 110010 110010 110101 110100 110010 110101 110111 110010 100010 101100 100010 1100011 1100001 1110100 1100101 1100111 1101111 1110010 1111001 100010 111010 100010 1000111 1100101 1101110 1100101 1110010 1100001 1101100 100010 101100 100010 1100011 1101000 1100101 1100011 1101011 1100101 1100100 100010 111010 1100110 1100001 1101100 1110011 1100101 1111101 1011101 101100 100010 1110100 1100001 1110011 1101011 1110011 1001000 1101001 1110011 1110100 1101111 1110010 1111001 100010 111010 1011011 1011101 101100 100010 1110100 1100001 1110011 1101011 1110011 1000100 1100101 1101100 1100101 1110100 1100101 1100100 100010 111010 1011011 1011101 1111101'

// Single quotations
{'categories':[{'id':'General','description':'General','tasksToBeExecuted':[{'title':'pasted','uid':'uid1610722542572','category':'General','checked':true}],'tasksHistory':[],'tasksDeleted':[]}


// Double quotations
{
	"categories": [{
		"id": "General",
		"description": "General"
	}],
	"tasksToBeExecuted": [{
		"title": "pasted",
		"uid": "uid1610722542572",
		"category": "General",
		"checked": true
	}],
	"tasksHistory": [],
	"tasksDeleted": []
}

*/


function decodeBinary(binary){
  //console.log('decodeBinary', binary)

  // Step 1 
  // Split the binary into an array of strings using the .split() method
  binary = binary.split(' ');
  // Step 2
  // Iterate over the elements of the new array create to change each element to a decimal
  binary = binary.map(elem => parseInt(elem,2));
  // Step 3
  // Use String.fromCharCode with .map() to change each element of the array to text 
  binary = binary.map(elem => String.fromCharCode(elem));
  // Step 4
  // Add the element of the new array together to create a string. Save it to a new Variable.
  let newText = binary.join("");
  // Step 5 
  // The new string is returned
  return newText;
}



// Check if localStorage DB exists, otherwise use hardcoded DB
function getDataBase() {
  if (navigator.onLine) {
    retrievingDataSpinner.style.display = 'inherit'
    lockOverlay.style.display = 'inherit'
      //    console.log('yes ponline')
        // dbBioRobot = 
    <?php
    /*

      function getDataBasePHP() {
        

        //$sql = "select * from users where userName = 'FrankVonk'";
        $sql = "select * from users where userName = 'TestUser'";
        $dbh = new PDO($DB_CONNSTRING, $DB_USERNAME, $DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;

        // if($rij && $rij['jsonTasks'] && ($rij['jsonTasks'] !== "")) {
        if ($rij) {
          return $rij['jsonTasks'];
        } else {
          return '{
            "categories": [
              { id: "General", description: "General", displayContent: true },
            ],
            "tasksToBeExecuted": [
              { "title": "PHP Fail", "uid": "uid1610722542572", "category": "General" },
            ],
            "tasksHistory": [
            ],
            "tasksDeleted": []
          }';

        //   $db = (object) [
        //     'categories' => 'de'
        //   ];
        //   $db = { "categories": [
        //     { id: "General", description: "General", displayContent: true, timeBlocks: { toggle: false, startTime: null } },
        //   ],
        //   "tasksToBeExecuted": [
        //     { "title": "this is a testcard", "uid": "uid1608751329sfdgcv598445", "category": "uid1609847627878" },
        //   ],
        // }
          
           
        }

        // $dbh = null;            
      } // End function

      print getDataBasePHP();
*/
?>
    //console.log('found db =', dbBioRobot);
    //console.log('decoded db =', JSON.parse(decodeBinary(dbBioRobot))  );

    
    
  //  console.log('found db php =', dbBioRobot);
    
    //dbBioRobot = JSON.parse(decodeBinary(dbBioRobot));
   // console.log('found db =', dbBioRobot);



    $.ajax({
      data: {
        "action": "getDatabase",
        //"userName": "FrankVonk",
        "userName": window.localStorage['userName'],
        //"password": "VonkFrank",
        "password": window.localStorage["password"],
        DB_CONNSTRING,
        DB_USERNAME,
        DB_PASSWORD
      },
      url: 'controller.php',
      method: 'GET',
      success: function(msg) {

        if (msg.length > 4) {
          //console.log('msg = ',msg)
          // WHYYYYYYY???? 5555555 first empty spaces????
          msg = msg.slice(5,-1);
          //msg = msg.slice(1,-1);
          dbBioRobot = JSON.parse(decodeBinary(msg));

          retrievingDataSpinner.style.display = 'inherit'
          renderTasks();
          renderCategoryButtons()
          // console.log('new db =', dbBioRobot);
          retrievingDataSpinner.style.display = 'none'
          lockOverlay.style.display = 'none'







          // For counting and finding lost tasks
          // dbBioRobot.categories.forEach(category => {
          //   dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
          //     if (task && task.category === category.id)
          //       dbBioRobot.tasksToBeExecuted[index].hasCat = true;
          //   })
          // })
          // console.log('listOfTasksThatHaveNoCategoryAnymore db = ', dbBioRobot)
          // let arr = [];
        
          // dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
          //   if (!task.hasCat)
          //     arr.push(task)
          // })
          // console.log('stray tasks: ', arr)








        } else {
          //alert('empty')
          renderToast({label: 'Database Request', content: 'No user found. You are not connected.', className: 'css hulpklasse'})
        }
      },
      // NOT TESTED IF ERROR ACTUALLY IS A VALID METHOD
      //error: function(msg) {
      //  alert(msg);
      //  console.log('error = ',msg)
      //},  
    });
  }
  else if (false && (window.localStorage['BIOROBOT'] && window.localStorage['BIOROBOT'] !== "")) {
    // window.alert(1)
    dbBioRobot = JSON.parse(window.localStorage['BIOROBOT']);
    console.log('found db =', dbBioRobot);
  } else if (typeof (dbBioRobotExport) !== 'undefined') {
    // searches for file in this folder
    // window.alert(2)
    /*
    console.log('Importing previously exported DB');
    window.localStorage['BIOROBOT'] = JSON.stringify(dbBioRobotExport); 
    dbBioRobot = dbBioRobotExport;   
    */
  } else {
    // window.alert(3)
    console.log('no db found, setting default DB');
  }
}




/*
// this could be helpful to converse a db 
// Convert database to newly added attributes
function updateCategoriesWithNewAttributes() {
  dbBioRobot.categories.forEach(cat => {
    if(!cat.timeBlocks) {
      console.log('resetting Timeblocks')
      cat.timeBlocks = {};
      cat.timeBlocks.toggle = false;
      cat.timeBlocks.startTime = null;
    }
  })
  updateLocalStorage(dbBioRobot);
}
updateCategoriesWithNewAttributes()
*/




function setDefaultSettings(defaultCatId) {
  // console.log('called setDefaultSettings', defaultCatId)
  setTimeout(() => {
    setCategory(defaultCatId);
  }, 200)
}
const defaultCategoryId = 'General'; // IS UID, not title
let lastSelectedCategory = null;
if (window.localStorage['taskCategoryId'] && window.localStorage['taskCategoryId'] !== '') {
  // console.log('lastSelectedCategory = ', lastSelectedCategory)
  lastSelectedCategory = window.localStorage['taskCategoryId'];
}
let preSelectThisCategory = lastSelectedCategory || defaultCategoryId;
// console.log('defaultCategoryId = ', defaultCategoryId)

// console.log('set this as initial cat == ', preSelectThisCategory)
// console.log('set this as initial cat == ', JSON.stringify( preSelectThisCategory))
// console.log('set this as initial cat3  == ', typeof(preSelectThisCategory))
setDefaultSettings(preSelectThisCategory);

if (window.localStorage['userName'] && window.localStorage['password']) {
  //Call SQL
  getDataBase();
} else {
  //alert('gimme<p>dsfg</p>')
 
  const content = [];
  let tr = newTr();
  let td = newTd('Please enter credentials to acces your database'); 
  td.colSpan = 4;
  td.class = ""
  tr.append(td);
  content.push(tr)

  tr = newTr();
  td = newTd('username:');
  td.colSpan = 2;
  tr.append(td);
  
  let inputfield = document.createElement('input');
  inputfield.id = 'userName'
  td = newTd();

  td.appendChild(inputfield); 
  td.colSpan = 2;
  td.class = ""
  tr.append(td);
  content.push(tr)

  tr = newTr();
  td = newTd('password:');
  td.colSpan = 2;
  tr.append(td);
  
  inputfield =document.createElement('input');
  inputfield.id = 'password'
  td = newTd();
  td.appendChild(inputfield); 
  td.colSpan = 2;
  td.class = ""
  tr.append(td);
  content.push(tr)

      
  renderGeneralModal({
    label: "Say the magic word!",
    content,
    onCancel: {
      render: true,
      label: "Cancel",
      method: () => {},
    },
    onAccept: {
      render: true,
      label: "Accept",
      method: () => {
        //localStorage.removeItem('BIOROBOT');
        //window.location.reload();    
       // setCategory(defaultCategoryId);
        window.localStorage['userName'] = document.getElementById('userName').value;
        window.localStorage['password'] = document.getElementById('password').value;
        hideGeneralModal();
        getDataBase();
       
      }
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_enterCredentials"
  })


  
 
 
}

renderCategoryButtons();
renderTasks();


function convert(dataToConvert) {
  let newBinaryString = "";
  
  for (var i = 0; i < dataToConvert.length; i++) {
    newBinaryString += dataToConvert[i].charCodeAt(0).toString(2) + " - ";
  }
  return newBinaryString;
}

function text2Binary(string) {
    return string.split('').map(function (char) {
        return char.charCodeAt(0).toString(2);
    }).join(' ');
}

// Store DB in window.localStorage
function updateLocalStorage(dbBioRobot) {
  if (savingSpinner)
    savingSpinner.style.display = 'inherit'
  
    // console.log('saving db ', dbBioRobot)
  dbBioRobot = text2Binary(JSON.stringify(dbBioRobot));
  // window.localStorage['BIOROBOT'] = JSON.stringify(dbBioRobot);


  let dbString = '"';
  dbString += JSON.stringify(dbBioRobot).replaceAll('"', "'");
  dbString += '"';   


  $.ajax({
    data: {
      "action": "updateDatabase",
      "updatedDatabase": dbString,
      "userName": window.localStorage["userName"],
      "password": window.localStorage["password"],
      DB_CONNSTRING,
      DB_USERNAME,
      DB_PASSWORD
    },
    url: 'controller.php',
    method: 'POST', // or GET
    success: function(msg) {
      // alert(msg);
      if (savingSpinner) {
        savingSpinner.style.display = 'none'
      }
    }
  });


// create backup-offline version using localStorage
  if (navigator.onLine) {


  } else {

  }


}
























// Currently selected category for new task
function setCategory(categoryId) {
  // console.log('called setCategory for id: ', categoryId)

  window.localStorage['taskCategoryId'] = categoryId
  // console.log('setcategory = ', category)
  // Reset css for all other categories
  dbBioRobot.categories.forEach(category => {
    const categoryElement = document.getElementById(category.id);
    if (categoryElement) {
      // reset the css on the createnewtast menu list of categories
      // categoryElement.style.background = 'white';
      // categoryElement.style.color = 'hotpink';
      categoryElement.classList.remove('extraforselectedcategoryheader');
      categoryElement.classList.add('notselectedcategoryheader');
    }
  })

  const categoryBtn = document.getElementById(categoryId);
  if (categoryBtn) {
    // categoryBtn.style.background = 'hotpink';
    // categoryBtn.style.color = 'white';
    categoryBtn.classList.remove('notselectedcategoryheader');
    categoryBtn.classList.add('extraforselectedcategoryheader');
  }
  newTaskCategory = categoryId;
  const category = dbBioRobot.categories.find(category => category.id == categoryId)
  // if (category)
    // console.log('found cat = ', category)
  
  renderTasks();
  
  // Auto focus on new task creation
  const x = window.scrollX;
  const y = window.scrollY;
  newTaskTitleTextArea.focus()
  // Scroll to the previous location
  window.scrollTo(x, y);

  SubmitNewCategoryOnEnter();
}


















// Delete DB and reset all tasks to hardcoded DB
function resetDataBase() {
  renderGeneralModal({
    label: "Please confirm your action",
    content: "Are you sure you want to delete your DataBase in the browser and reset it to the template DataBase?",
    onCancel: {
      render: true,
      label: "Cancel",
      method: () => {},
    },
    onAccept: {
      render: true,
      label: "Accept",
      method: () => {
        localStorage.removeItem('BIOROBOT');
        window.location.reload();    
        setCategory(defaultCategoryId);
        hideGeneralModal();
      }
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_resetDataBase"
  })
}






// todo validate the json here after clicking "import",
// render warning in the same modal if it's not valid

// Import tasks from user as JSON
function importDataBase() {
  let content = [];

  let tr = newTr();
  td = newTd();
  td.colSpan = 4;
  let importFieldTasks = document.createElement('input');
  importFieldTasks.placeholder = "Copy Content here"
  importFieldTasks.id = 'modal_import-database-input-field';
  td.appendChild(importFieldTasks);
  tr.appendChild(td);
  content.push(tr);

  tr = newTr();
  td = newTd();
  let label = document.createElement('label');
  label.for = 'dataBaseMergeInsteadOfReplace';
  label.innerHTML = 'Merge data instead of replace';
  td.appendChild(label)
  td.colSpan = 2;
  tr.appendChild(td);

  td = newTd();
  let inputField = document.createElement('input');
  inputField.setAttribute('type', 'checkbox');
  inputField.id = 'dataBaseMergeInsteadOfReplace';
  inputField.name = 'dataBaseMergeInsteadOfReplace';
  inputField.checked = true;
  td.appendChild(inputField);
  tr.appendChild(td);

  content.push(tr);

  renderGeneralModal({
    label: "Paste your JSON content here",
    content,
    onCancel: {
      render: true,
      label: "Cancel",
      method: () => {},
    },
    onAccept: {
      render: true,
      label: "Import",
      method: () => {
        const data = document.getElementById('modal_import-database-input-field');
        const dataBaseMergeInsteadOfReplace = document.getElementById('dataBaseMergeInsteadOfReplace').checked;
        if (isValidJsonString(data.value)) {
          if (dataBaseMergeInsteadOfReplace) {
            console.log('merging db')
            mergeDatabases(JSON.parse(data.value));

          } else {
            console.log('replacing db')
            console.log('fa = ', data)
            console.log('val = ', data.value)
            dbBioRobot = JSON.parse(data.value);
            //dbBioRobot = (data.value);
          }
          updateLocalStorage(dbBioRobot);
          // updateLocalStorage() window.localStorage['BIOROBOT'] = JSON.stringify(dbBioRobot);
          renderTasks()
          renderCategoryButtons();    
          hideGeneralModal();
        } else {
          document.getElementById("modal_warning").innerHTML = "This is not valid JSON: " + data.value;
        }
      }
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_import-database"
  })
}

//console.log("huh?", isValidJsonString('{ "Id": 1, "Name": "Coke" }'))

function isValidJsonString(str) {
  try {
      JSON.parse(str);
  } catch (e) {
      return false;
  }
  return true;
}




// Store tasks from localhost in downloadable JSON
function exportDataBase() {
  let data = encodeURIComponent(JSON.stringify(dbBioRobot));
  var dataStr = "data:application/json;charset=utf-8," + data;
  var dlAnchorElem = document.createElement('a');
  dlAnchorElem.setAttribute("href", dataStr);
  // dlAnchorElem.setAttribute("download", "dbBioRobot.js");
  dlAnchorElem.setAttribute("download", "dbBioRobot.json");
  dlAnchorElem.click();
}




function renderTasksInBin() {
  setOverlayHeightToFull()

  const binIsEmpty = dbBioRobot.tasksDeleted.length === 0;
  // Reset is needed as this screen refreshes after undoing a deletion
  modal.innerHTML = "";
   renderGeneralModal({
    label: "Deleted Tasks",
    content: binIsEmpty
      ? "There are no tasks in the recycle bin"
      : displayListOfTasksInBin("bin"),
    onCancel: {
      render: true,
      label: binIsEmpty ? "Ok" : "Cancel",
      method: () => {},
    },
    onAccept: {
      render: !binIsEmpty,
      label: "Empty the bin",
      method: () => {
        dbBioRobot.tasksDeleted = [];
        updateLocalStorage(dbBioRobot);
        hideGeneralModal();
      }
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_bin"
  })
}




function displayListOfTasksInBin() {
  const arrTasksInBin = [];
  dbBioRobot.tasksDeleted.forEach(task => {
    // ROW
    tr = newTr();
    // CELL
    td = newTd(task.title);
    td.rowSpan = 2;
    td.colSpan = 2;
    td.className = 'bcWhite bgwhite cCornBlue binTaskTitle';
    tr.appendChild(td);
    // CELL
    // Get category title using id
    const category = dbBioRobot.categories.filter(c => c.id === task.category);
    let categoryTitle = '';
    if (category.length === 0) {
      categoryTitle = 'Category is deleted';
      task.category = 'General';
    } else {
      categoryTitle = category[0].description;
    }
    td = newTd(categoryTitle);
    td.colSpan = 2;
    td.className = '';
    tr.appendChild(td);
    arrTasksInBin.push(tr);
    // ROW
    tr = newTr();
    // CELL
    td = newTd('Undo Deletion');
    td.onclick = () => {
      dbBioRobot.tasksDeleted.forEach((x, index) => {
        if (x.uid === task.uid) {
          dbBioRobot.tasksDeleted.splice(index, 1);
          dbBioRobot.tasksToBeExecuted.push(task)
          updateLocalStorage(dbBioRobot);
        }
      })
      renderTasksInBin()
      renderTasks()
    }
    td.className = ' ';
    tr.appendChild(td);
    // CELL
    td = newTd('Erase');
    td.onclick = () => {
      dbBioRobot.tasksDeleted.forEach((x, index) => {
        if (x.uid === task.uid) {
          dbBioRobot.tasksDeleted.splice(index, 1);
          updateLocalStorage(dbBioRobot);
        }
      })
      renderTasksInBin()
    }
    td.className = '';
    tr.appendChild(td);
    arrTasksInBin.push(tr);
  })
  return arrTasksInBin
}



function setOverlayHeightToFull() {
  const body = document.body;
  const html = document.documentElement;

  const height = Math.max(body.scrollHeight, body.offsetHeight,
  html.clientHeight, html.scrollHeight, html.offsetHeight);
  lockOverlay.style.height = height+'px';
  savingSpinnerParent.style.height = height+'px';
  
}





function renderTasksInHistory() {
  setOverlayHeightToFull()
  // Reset is needed as this screen refreshes after undoing a deletion
  modal.innerHTML = "";
  const taskHistoryIsEmpty = dbBioRobot.tasksHistory.length === 0;
  renderGeneralModal({
    label: "History of Tasks",
    content: taskHistoryIsEmpty
      ? "There are no tasks in history"
      : displayListOfTasksInHistory(),
    onCancel: {
      render: true,
      label: taskHistoryIsEmpty ? "Ok" : "Cancel",
      method: () => {},
    },
    onAccept: {
      render: !taskHistoryIsEmpty,
      label: "Clear history",
      method: () => {
        dbBioRobot.tasksHistory = [];
        updateLocalStorage(dbBioRobot);
        hideGeneralModal();
      }
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_history"
  })
}






// Open popup with bin to permanently erase OR undo deleted tasks
function displayListOfTasksInHistory() {
  const arrTasksInHistory = [];
  dbBioRobot.tasksHistory.forEach(task => {
    // ROW
    tr = newTr();
    // CELL
    td = newTd(task.title);
    td.rowSpan = 2;
    td.colSpan = 2;
    td.className = 'bcWhite bgwhite cCornBlue binTaskTitle';
    tr.appendChild(td);
    // CELL
    // Get category title using id
    const category = dbBioRobot.categories.filter(c => c.id === task.category);
    let categoryTitle = '';
    if (category.length === 0) {
      categoryTitle = 'Category is deleted';
      task.category = 'General';
    } else {
      categoryTitle = category[0].description;
    }
    td = newTd(categoryTitle);
    td.colSpan = 2;
    td.className = '';
    tr.appendChild(td);
    arrTasksInHistory.push(tr);
    // ROW
    tr = newTr();
    // CELL
    td = newTd('Reset Task');
    td.onclick = () => {
      dbBioRobot.tasksHistory.forEach((x, index) => {
        if (x.uid === task.uid) {
          dbBioRobot.tasksHistory.splice(index, 1);
          dbBioRobot.tasksToBeExecuted.push(task)
          updateLocalStorage(dbBioRobot);
        }
      })
      renderTasksInHistory()
      renderTasks()
    }
    td.className = ' ';
    tr.appendChild(td);
    // CELL
    td = newTd('Erase');
    td.onclick = () => {
      dbBioRobot.tasksHistory.forEach((x, index) => {
        if (x.uid === task.uid) {
          dbBioRobot.tasksHistory.splice(index, 1);
          updateLocalStorage(dbBioRobot);
        }
      })
      renderTasksInHistory()
    }
    td.className = '';
    tr.appendChild(td);
    arrTasksInHistory.push(tr);
  })
  return arrTasksInHistory
}








// Rendering buttons for categories on Create new task panel
function renderCategoryButtons() {
  // console.log('current cat1 = ',
  newTaskCategoryGrid.innerHTML = null;
  // Create new table row for each category
  if (dbBioRobot) {

    dbBioRobot.categories.forEach(category => {

      let catTitle = document.createElement('div');
      catTitle.addEventListener('click', () => setCategory(category.id));
      catTitle.setAttribute('id', category.id);

      let tn = document.createTextNode(category.description.replaceAll('&nbsp;', ' '));
      catTitle.appendChild(tn);
      catTitle.className = "createNewTask_CategoryName";
      if (category.id !== window.localStorage['taskCategoryId']) {
        catTitle.classList.add('notselectedcategoryheader')
      } else {
        catTitle.classList.add('extraforselectedcategoryheader')
      }
      if (category.description === defaultCategoryId) {
        catTitle.classList.add('defaulCategory')
      }
      newTaskCategoryGrid.appendChild(catTitle);

      // Default category has no delete button
      if (category.description !== defaultCategoryId) {
        let deleteButton = document.createElement('div');
        deleteButton.addEventListener('click', () => deleteCategory(category.id));
        deleteButton.setAttribute('id', category.id + 'style');
        deleteButton.setAttribute('title', "Delete Category " + category.id);
        deleteButton.className = 'createNewTask_CatDeleteBtn';

        tn = document.createTextNode('X');
        deleteButton.appendChild(tn);

        newTaskCategoryGrid.appendChild(deleteButton);
      }
    })
  }
}


// Listener for inputfield of new category

// SubmitNewCategoryOnEnter
function SubmitNewCategoryOnEnter() {
  newCategoryInput.addEventListener('keypress', (e) => {
  console.log('hi there keypress')

    if (e.key === 'Enter' && newCategoryInput.value.length > 4) {
      createNewCategory()
      console.log('hi there keypress deeper')
    }
  });
}
SubmitNewCategoryOnEnter();


// Create new category
function createNewCategory() {
  console.log('hi there')
  if (newCategoryInput.value !== '' && categoryDoesNotExistYet(newCategoryInput.value)) {
    const id = 'uid' + new Date().getTime();
    const newCategory = {
      id,
      description: newCategoryInput.value,
      displayContent: true,
    }
    dbBioRobot.categories.unshift(newCategory);
    renderCategoryButtons();
    renderTasks();
    setCategory(id)
    updateLocalStorage(dbBioRobot);


    newCategoryInput.value = "";
    newTaskTitleTextArea.focus()



  } else if (!categoryDoesNotExistYet(newCategoryInput.value)) {
 
    renderGeneralModal({
      label: "Create new Category",
      content: 'A category with the title "' + newCategoryInput.value + '" already exists',
      onCancel: {
        render: false,
        label: "Cancel",
        method: () => {}
      },
      onAccept: {
        render: true,
        label: "Ok",
        method: () => {
          hideGeneralModal();
        }
      },
      canClickOutside: true,
      canClickEscapeKey: true,
      className: "modal_new-category_already-exists"
    })
  }
}


// Check if category already exists 
function categoryDoesNotExistYet(categoryTitle) {
  let notFound = true;
  dbBioRobot.categories.forEach(cat => {
    //    console.log(cat)
    if (cat.description === categoryTitle) {
      notFound = false;
    }
  })
  return notFound;
}


// Delete a category
function deleteCategory(categoryToDeleteId) {
 
  // Check if the category still has tasks assigned to it
  let allowed = true;
  dbBioRobot.tasksToBeExecuted.forEach(task => {
    if (task.category === categoryToDeleteId) {
      allowed = false;
    }
  })
  let categoryToDeleteObject = {};
  let indexOfCategory = null;
  dbBioRobot.categories.forEach((category, index) => {
    if (category.id === categoryToDeleteId) {
      indexOfCategory = index;
      categoryToDeleteObject = dbBioRobot.categories[indexOfCategory];
    }
  })

  if (allowed) {
    dbBioRobot.categories.splice(indexOfCategory, 1);
    addDeletedCategoryToCategoriesDeleted(categoryToDeleteObject);

    // Reset the defaultCategory in case that you have deleted it
    if (window.localStorage['taskCategoryId'] === categoryToDeleteId) {
      window.localStorage['taskCategoryId'] = defaultCategoryId;
    }
    updateLocalStorage(dbBioRobot)

    setTimeout(() => {
      setCategory(defaultCategoryId);
    }, 200)
  
    renderCategoryButtons();
    renderTasks()
    
  } else {

    const content = [];
    let tr = newTr();
    let td = newTd('Warning, Deleting category "' + categoryToDeleteObject.description + '" will also delete these tasks still belonging to it:'); 
    td.colSpan = 4;
    td.class = "modal_deleting-category_warning"
    tr.append(td);
    content.push(tr)

    dbBioRobot.tasksToBeExecuted.forEach(task => {
      if (task.category === categoryToDeleteObject.id && task.title !== "empty") {
        tr = newTr();
        td = newTd(task.title);
        td.className = '';
        td.colSpan = 3;
        tr.appendChild(td);
        content.push(tr)
      }
    })

    renderGeneralModal({
      label: "Deleting Category",
      content,
      onCancel: {
        render: true,
        label: "Cancel",
        method: () => {},
      },
      onAccept: {
        render: true,
        label: "Delete Category",
        method: () => {
          deleteCategoryWithTasks(categoryToDeleteObject);
          hideGeneralModal();
        }
      },
      canClickOutside: true,
      canClickEscapeKey: true,
      className: "modal_deleting-category"
    })
  }
}


// Add deleted category to categoriesDeleted
function addDeletedCategoryToCategoriesDeleted(category) {
  if (!dbBioRobot.categoriesDeleted) {
    dbBioRobot.categoriesDeleted = [category];
  } else {
    dbBioRobot.categoriesDeleted.push(category);
  }
  updateLocalStorage(dbBioRobot)
}


// Delete category including tasks belonging to it.
function deleteCategoryWithTasks(categoryToDeleteObject) {
  // console.log("deleteCategoryWithTasks = ", categoryToDeleteObject)
  // Delete Tasks
  let newArrayTasksToBeExecuted = [];
  dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
    if (task.category !== categoryToDeleteObject.id) {
      newArrayTasksToBeExecuted.push(dbBioRobot.tasksToBeExecuted[index]);
    } else {
      dbBioRobot.tasksDeleted.push(task);
    }
  })
  // Reset db with tasks not belonging to deleted category
  dbBioRobot.tasksToBeExecuted = newArrayTasksToBeExecuted;
  // Delete Category
  deleteCategory(categoryToDeleteObject.id)

  renderTasks();
  renderCategoryButtons();
  updateLocalStorage(dbBioRobot);
}


// Set newly created task first or last in list
let newTaskIsFirstOrLast = "first";
btnSetTaskFirst.onclick = () => {
  newTaskIsFirstOrLast = "first";

  btnSetTaskFirst.classList = "default-order-new-task selected"
  btnSetTaskLast.classList = "default-order-new-task not-selected"
}
btnSetTaskLast.onclick = () => {
  newTaskIsFirstOrLast = "last";

  btnSetTaskLast.classList = "default-order-new-task selected"
  btnSetTaskFirst.classList = "default-order-new-task not-selected"
}




// Add new task to DB
function submitTask() {
  l('cat = ', newTaskCategory)
  if (newTaskCategory !== "") {
    const newTask = {
      title: newTaskTitleTextArea.value,
      uid: 'uid' + new Date().getTime(),
      category: newTaskCategory,
    }

    const category = dbBioRobot.categories.find((cat) => cat.id === newTaskCategory);

    // l(newTask);
    if (newTaskIsFirstOrLast === "first") {
      dbBioRobot.tasksToBeExecuted.unshift(newTask);
    } else {
      dbBioRobot.tasksToBeExecuted.push(newTask);
    }
    updateLocalStorage(dbBioRobot);
    // l('submitted tasks no it\'s', JSON.parse(window.localStorage['BIOROBOT']))
    // console.log('local = ', JSON.parse(window.localStorage['BIOROBOT']));
    renderTasks();
    // newTaskTitleTextArea.value = "";
    // newTaskCategory = "";
  }
  renderTasks();
  newTaskTitleTextArea.focus();
  newTaskTitleTextArea.value = "";
}


// SubmitNewTaskOnEnter
function SubmitNewTaskOnEnter() {
  newTaskTitleTextArea.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && newTaskTitleTextArea.value.length > 4) {
      e.preventDefault();
      submit.click();
      newTaskTitleTextArea.focus();
      // newTaskTitleTextArea.innerHTML = "";
      // newTaskTitleTextArea.value = "";
    }
  });
  // console.log('SubmitNewTaskOnEnter')
}
SubmitNewTaskOnEnter();

















// Loop categories to create category cluster in a table
function renderTasks() {
  categoryContainer.innerHTML = "";
  categoryContainer.appendChild(createNewTaskGrid);


  // Update the counter in the header with the current amount of tasks to be executed
  const counterTasks =document.getElementById('counterTasks')
  if (counterTasks)
    counterTasks.innerHTML = dbBioRobot.tasksToBeExecuted.length;
    counterthing = 0;

  dbBioRobot.categories.forEach(category => {
    // console.log('renderTasks  cat =', category )

    let flow = document.createElement('div');

    flow.className = category.highlight
      ? 'flow highlight1'
      : 'flow'

    let displayContainer = document.createElement('div');
    displayContainer.className = 'masterTask';

    // Header title of category + left right buttons
    let table = document.createElement('table')
    table.setAttribute('id', category.id + 'table');
    table.className = 'categoryHeaderTable';
    let tableRow = document.createElement('tr')

    // Header title
    let tableHeader = document.createElement('th')
    let text = document.createTextNode(category.description.replaceAll('&nbsp;', ' '));
    tableHeader.appendChild(text);
    tableHeader.className = 'categoryHeader';
    
    if (category.id == window.localStorage['taskCategoryId']) {
      tableHeader.classList += ' extraforselectedcategoryheader';
    } else {
      tableHeader.classList += ' notselectedcategoryheader';

    }

    tableHeader.setAttribute('id', 'categoryTitleUidIs' + category.id);
    tableHeader.setAttribute('rowspan', '1');
    tableHeader.setAttribute('colspan', '4');
    tableHeader.onclick = () => {
      setCategory(category.id)
    };
    tableHeader.addEventListener('contextmenu', (event) => {
      event.preventDefault();
      toggleDisplayCategoryTasks(category.id)
    });



    tableRow.appendChild(tableHeader)
    table.appendChild(tableRow);
    
    tableRow = document.createElement('tr')

    // Move category left button
    tableHeader = document.createElement('th')
    text = document.createTextNode('<');
    //    text = document.createTextNode('\\u00D3\\u00CB &#215;....');

    tableHeader.appendChild(text);
    tableHeader.addEventListener('click', () => moveCategoryLeftOrRight('left', category));
    tableHeader.className = 'arrowLeftRight';
    tableHeader.setAttribute('id', category.id + 'arrowLeft');
    tableRow.appendChild(tableHeader)
    table.appendChild(tableRow);

 

    // Edit category title button
    const stringLabelToggleCategory = category.displayContent
      ? "Fold"
      : "Show"
    let td = newTd(stringLabelToggleCategory);
    td.className = "toggle-category";
    td.onclick = () => toggleDisplayCategoryTasks(category.id);
    tableRow.appendChild(td)
    table.appendChild(tableRow);

    // Edit category title button
    tableHeader = document.createElement('th')
    text = document.createTextNode('Edit');
    tableHeader.appendChild(text);
    tableHeader.className = 'editCategory';
    tableHeader.setAttribute('id', 'categoryEditBtnUidIs' + category.id);
    tableHeader.addEventListener('click', () => editCategory(category));
    tableRow.appendChild(tableHeader)
    table.appendChild(tableRow);


    // Move category right button
    tableHeader = document.createElement('th')
    text = document.createTextNode('>');
    // text = document.createTextNode('►');
    tableHeader.appendChild(text);
    tableHeader.addEventListener('click', () => moveCategoryLeftOrRight('right', category));
    tableHeader.className = 'arrowLeftRight';
    tableHeader.setAttribute('id', category.id + 'arrowRight');
    tableRow.appendChild(tableHeader)
    table.appendChild(tableRow);

    displayContainer.appendChild(table)

    if (category.displayContent == undefined || category.displayContent == true) {
      // Gather the tasks with this category
      let arrTasksWithThisCategory = [];
      dbBioRobot.tasksToBeExecuted.forEach(task => {
        if (task && task.category === category.id)
          arrTasksWithThisCategory.push(task)
      })

      let arrCatLength = arrTasksWithThisCategory.length;
      // Check as some categories might not have tasks associated with it
      if (arrTasksWithThisCategory.length > 0) {
        for (i = 0; i < arrCatLength; i++) {
          
          // Render all titles of a cat in a list to copy them
          // let place = document.getElementById("listtitles");
          // let par =document.createElement('p')
          // par.innerHTML = arrTasksWithThisCategory[i].title;
          // place.appendChild(par)
          // This is in index, uncomment to see the list
          //<!-- <div id=listtitles>put titles here</div> -->



          renderTask(displayContainer, arrTasksWithThisCategory[i]);

          // For counting and finding lost tasks
          //  counterthing ++;

        }
      }
    }  
    flow.appendChild(displayContainer);
    categoryContainer.appendChild(flow)
    // console.log("rendertask total = ", counterthing)
  })
  // For counting and finding lost tasks
  // console.log("rendertask total = ", counterthing)
  //  counterthing = 0;

  // Update height of page to overlay items
  setOverlayHeightToFull()

}


// Render single task in the element of it's category
function renderTask(displayContainer, task) {

  //   console.log('renderTask krijgt dit = ', task)
  const taskTable = document.createElement('table');
  taskTable.className = 'taskTable';
  taskTable.setAttribute('id', task.uid);


  // Title of task
  const taskTableTr1 = document.createElement('tr');
  taskTableTr1.className = "task-table-tr1";

  const taskTableTd1 = document.createElement('td');
  taskTableTd1.className = 'taskTitle';
  taskTableTd1.setAttribute('id', 'taskTitleUidIs' + task.uid);
  taskTableTd1.setAttribute('colspan', '6');
  const taskTableTn1 = document.createTextNode(task.title.replace('&nbsp', ' '))
  taskTableTd1.appendChild(taskTableTn1);
  if (task.title == "") {
    // taskTableTd1.style.visibility = 'hidden'
    taskTableTd1.classList.add('emptyTaskTitle');
  }
  taskTableTr1.appendChild(taskTableTd1);
  taskTable.appendChild(taskTableTr1);

  // Link of task
  if (task.linkLabel && task.linkURL) {

    let trLink = document.createElement('tr');
    let tdLink = document.createElement('td');

    trLink.className = "task-table-tr-link";

    let tdLinkAnchor = document.createElement('a');
    tdLinkAnchor.className = 'taskLink';
    tdLinkAnchor.target = '_blank';
    tdLink.setAttribute('colspan', '6');

    let linkURL = task.linkURL;
    // Check if linkURL starts with 'http://' or 'https://'
    if (!linkURL.startsWith('http://') && !linkURL.startsWith('https://')) {
      // If not, prepend 'http://'
      linkURL = 'http://' + linkURL;
    }

    const tn = document.createTextNode(task.linkLabel)
    tdLinkAnchor.appendChild(tn);
    tdLinkAnchor.href = linkURL;
    tdLink.appendChild(tdLinkAnchor);
    trLink.appendChild(tdLink);
    taskTable.appendChild(trLink);
  }

  // Delete task
  const taskTableTr2 = document.createElement('tr');
  taskTableTr2.className = "task-table-tr2";
  taskTable.appendChild(taskTableTr2);


  let td;

  const taskTableTd5 = document.createElement('td');
  taskTableTd5.className = 'task_delete';
  const taskTableTn5 = document.createTextNode('Delete');
  taskTableTd5.appendChild(taskTableTn5);



  taskTableTd5.addEventListener('click', () => deleteTask(task.uid, false));
  taskTableTr2.appendChild(taskTableTd5);

  // Checkbox for task
  const taskTableTd8 = document.createElement('td');

  const spanCheckBox = document.createElement('span');

  if (task.checked) {
    taskTableTd8.className = 'task-checkbox-container-checked';
  }
  else {
    taskTableTd8.className = 'task-checkbox-container-unchecked';
  }

  taskTableTd8.className = task.checked
    ? 'task-checkbox-container-checked'
    : 'task-checkbox-container-unchecked'


  const canvasCheckBox = document.createElement('canvas');
  canvasCheckBox.setAttribute('id', 'myCanvas');
  canvasCheckBox.style.height = '20px';
  // canvasCheckBox.style.width = '18px';
  canvasCheckBox.style.width = '28px';

  let c = canvasCheckBox; // document.getElementById("myCanvas");
  var ctx = c.getContext("2d");

  

  switch(localStorage['THEME']) {
    case "black":
      ctx.strokeStyle = task.checked ? 'black' : '#AE57FF';
      break;  
    case "sun-gym":
      ctx.strokeStyle = task.checked ? 'white' : 'silver';
      break;
    case "the-white-lotus":
      ctx.strokeStyle = task.checked ? '#ebdac0' : 'rgb(36,47,39)';
      break;
    case "green-spacious":
      ctx.strokeStyle = task.checked ? 'darkseagreen' : 'indianred';
      break;
    case "wireframe":
      ctx.strokeStyle = task.checked ? '#ebdac0' : 'rgb(36,47,39)';
      break;  

    default:
    ctx.strokeStyle = task.checked ? 'silver' : 'silver';
  }

  ctx.lineWidth = 25;
  ctx.beginPath();
  ctx.moveTo(20, 90);
  ctx.lineTo(120, 130);
  ctx.lineTo(290, 40);
  ctx.stroke();
  spanCheckBox.appendChild(canvasCheckBox);

  taskTableTd8.appendChild(spanCheckBox);
  taskTableTd8.setAttribute('onclick', 'markCheckBox(' + task.uid + ')');
  taskTableTd8.setAttribute('rowspan', '2');

  if (task.title == "empty")
    taskTableTd8.style.visibility = 'hidden'
  taskTableTr2.appendChild(taskTableTd8);



  // Move Task Up
  const taskTableTd6 = document.createElement('td');
  taskTableTd6.className = 'task_up';
  taskTableTd6.setAttribute('id', 'taskUp');

  let spanMoveTaskUpBtn = document.createElement('span');
  spanMoveTaskUpBtn.className = 'spanMoveTaskUpBtn';
  let tnSpanMoveTaskUpBtn = document.createTextNode('<');
  spanMoveTaskUpBtn.appendChild(tnSpanMoveTaskUpBtn);
  taskTableTd6.appendChild(spanMoveTaskUpBtn);

  taskTableTd6.setAttribute('onclick', 'moveTaskUpOrDown("up",' + task.uid + ')');
  taskTableTr2.appendChild(taskTableTd6);

  td = newTd('Done')
  td.className = 'task_down';
  td.setAttribute('rowspan', '2');
  td.onclick = () => markTaskAsDone(task.uid);
  if (task.title == "empty")
    td.style.visibility = 'hidden';

  taskTableTr2.appendChild(td);

  const tr = document.createElement('tr');
  tr.className = "task-table-tr3";


  taskTable.appendChild(tr);


  td = newTd('Edit')
  td.classList = 'task_edit'
  td.id = 'taskEditUidIs' + task.uid;
  td.onclick = () => editTask(task);
  tr.appendChild(td);



  // Move Task Down
  td = document.createElement('td');
  td.className = 'task_down';
  td.setAttribute('id', 'taskDown');
  // const taskTableTn7 = document.createTextNode('▼')
  spanMoveTaskDownBtn = document.createElement('span');
  spanMoveTaskDownBtn.className = 'spanMoveTaskDownBtn';
  tnSpanMoveTaskDownBtn = document.createTextNode('>');
  spanMoveTaskDownBtn.appendChild(tnSpanMoveTaskDownBtn);
  td.appendChild(spanMoveTaskDownBtn);

  td.setAttribute('onclick', 'moveTaskUpOrDown("down",' + task.uid + ')');
  tr.appendChild(td);


  displayContainer.appendChild(taskTable);
}








// Move category left or right
function moveCategoryLeftOrRight(direction, categoryIWantMoved) {
  console.log(categoryIWantMoved)
  const resetThisCategoryAfterwards = newTaskCategory;
  let indexOfCategoryToMove = 0;
  dbBioRobot.categories.forEach((category, index) => {
    if (category.id === categoryIWantMoved.id) {
      indexOfCategoryToMove = index;
    }
  })
  // remove category from old location
  dbBioRobot.categories.splice(indexOfCategoryToMove, 1);
  // insert category into new location
  dbBioRobot.categories.splice((direction === 'left' ? indexOfCategoryToMove - 1 : indexOfCategoryToMove + 1), 0, categoryIWantMoved);
  renderTasks();
  renderCategoryButtons();
  updateLocalStorage(dbBioRobot)
//  setCategory(resetThisCategoryAfterwards);
}



// Toggle all categories
let showAllTasks = true;
function toggleDisplayOfAllCategoryTasks() {
  dbBioRobot.categories.forEach(cat => {
    cat.displayContent = showAllTasks;
  })
  showAllTasks = !showAllTasks  
  updateLocalStorage(dbBioRobot);
  renderTasks();
}


// Toggle single category
function toggleDisplayCategoryTasks(catId) {
  // console.log('displ = ', catId)
  dbBioRobot.categories.forEach(cat => {
    if (cat.id === catId)
      cat.displayContent = !cat.displayContent;
  })
  updateLocalStorage(dbBioRobot);
  renderTasks();
}





// Edit properties of category
let newSettingsForCategory = {};
function editCategory(category) {
  // console.log('Edit category = ', category );
  newSettingsForCategory = {};

  // Adjust class of "Edit" btn in category
  const editBtn = document.getElementById('categoryEditBtnUidIs' + category.id)
  editBtn.class = 'category-header_edit-btn_selected'

  const content = [];

  
  // ROW for setting category first or last
  let tr = newTr();
  // CELL
  let td = newTd('Change order of Category');
  td.className = '';
  td.style.textAlign = 'right'
  td.rowSpan = 2;
  td.colSpan = 2;
  tr.appendChild(td);



  // CELL
  td = newTd('Set category first');
  td.className = 'model_edit-category_set-cat-order model_edit-category_set-cat-first_not-selected';
  td.id = 'btnMoveCategoryToTop';
  td.colSpan = 2;
  td.onclick = () => {
    // todo create single function for this and the part on the "Set category last" btn
    const btnMoveCategoryToBottom = document.getElementById('btnMoveCategoryToBottom');
    const btnMoveCategoryToTop = document.getElementById('btnMoveCategoryToTop');
    if (newSettingsForCategory.changeOrder === undefined || newSettingsForCategory.changeOrder === 'bottom') {
      newSettingsForCategory.changeOrder = 'top';
      btnMoveCategoryToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_selected';
      btnMoveCategoryToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    } else {
      newSettingsForCategory.changeOrder = undefined;
      btnMoveCategoryToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
      btnMoveCategoryToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    }
  }
  tr.appendChild(td);
  content.push(tr)

  // ROW
  tr = newTr();
  // CELL
  td = newTd('Set category last');
  td.className = 'model_edit-category_set-cat-order model_edit-category_set-cat-last_not-selected';
  td.colSpan = 2;
  td.id = 'btnMoveCategoryToBottom';
  td.onclick = () => {
    // todo create single function for this and the part on the "Set category first" btn
    const btnMoveCategoryToBottom = document.getElementById('btnMoveCategoryToBottom');
    const btnMoveCategoryToTop = document.getElementById('btnMoveCategoryToTop');
    if (newSettingsForCategory.changeOrder === undefined || newSettingsForCategory.changeOrder === 'top') {
      newSettingsForCategory.changeOrder = 'bottom';
      btnMoveCategoryToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_selected';
      btnMoveCategoryToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    } else {
      newSettingsForCategory.changeOrder = undefined;
      btnMoveCategoryToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
      btnMoveCategoryToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    }
  }
  tr.appendChild(td);
  content.push(tr)
 

  // Todo
  // You are not allowed to edit the title of the default category due to historic reasons.
  // This can be removed when changing default cat behaviour. possibility to set default in general settings menu.
  if (category.description !== defaultCategoryId) {
   





    // ROW
    tr = newTr();
    // CELL
    td = newTd('Edit title');
    td.className = '';
    td.colSpan = 2;
    tr.appendChild(td);

    // CELL
    td = newTd();
    td.className = '';
    td.colSpan = 2;

    const input = document.createElement('textarea');
    input.id = 'inputForChangingCategoryTitle';
    input.className = 'inputForChangingCategoryTitle';
    input.value = category.description;

    td.appendChild(input)
    tr.appendChild(td);
    content.push(tr);


  


  }


  // ROW
  tr = newTr();
  // CELL
  tr.id = 'placeCategoryDropDownOptionsAfterThis'
  td = newTd('Import tasks from category:');
  td.className = '';
  td.colSpan = 2;
  td.style.textAlign = 'right'
  tr.appendChild(td);
  // CELL

  // Current category as placeholder / default
  td = newTd("Choose cat to copy");
  td.className = '';
  td.id = 'placeHolderCategory'
  td.addEventListener('click', () => {
    // Remove eventlisteners
    var elem = document.getElementById('placeHolderCategory');
    elem.replaceWith(elem.cloneNode(true));
    // Race condition sets need for 2nd time
    var elem2 = document.getElementById('placeHolderCategory');
    elem2.className = 'bcHotpink bgHotpinkcCornBlue'
    attachDropDownOfCategoriesForEditingCategory(category)
  });
  tr.appendChild(td);
  content.push(tr)
  





  // ROW
  tr = newTr();
  // CELL
  tr.id = 'toggleCategoryHighlight'
  td = newTd('Highlight');
  td.className = '';
  td.colSpan = 2;
  //td.style.textAlign = 'right'
  tr.appendChild(td);
  // CELL
  const tdForCheckboxHighlight = document.createElement('td');
  const spanCheckBox = document.createElement('span');
  spanCheckBox.id = 'spanForCheckboxHighlight';

  if (category.highlight && category.highlight == true) {
    tdForCheckboxHighlight.className = 'task-checkbox-container-checked';
  } else {
    tdForCheckboxHighlight.className = 'task-checkbox-container-unchecked';
  }


  const canvasCheckBox = document.createElement('canvas');
  canvasCheckBox.setAttribute('id', 'myCanvas');
  canvasCheckBox.style.height = '20px';
  canvasCheckBox.style.width = '28px';
  canvasCheckBox.addEventListener('click', () => {
    console.log('click!!!')

    const spanForCheckboxHighlight = document.getElementById('spanForCheckboxHighlight')
    if (category.highlight && category.highlight == true) {
      category.highlight = false;
      spanForCheckboxHighlight.className = 'task-checkbox-container-unchecked';
    } else {
      category.highlight = true;
      spanForCheckboxHighlight.className = 'task-checkbox-container-checked';
    }
   // category.tasksToBeExecuted.forEach((task, index) => {
    //if (task && task.uid === id.id) {
    //  indexToAdjust = index;
  //  }
  //})
  })

  var ctx = canvasCheckBox.getContext("2d");


  switch(localStorage['THEME']) {
    case "sun-gym":
      // ctx.strokeStyle = task.checked ? 'white' : 'silver';
      ctx.strokeStyle = category.highlight ? 'white' : 'silver';
      break;
    default:
      ctx.strokeStyle = category.highlight ? 'silver' : 'silver';
  }

  ctx.lineWidth = 25;
  ctx.beginPath();
  ctx.moveTo(20, 90);
  ctx.lineTo(120, 130);
  ctx.lineTo(290, 40);
  ctx.stroke();
  spanCheckBox.appendChild(canvasCheckBox);
  tr.appendChild(spanCheckBox);
  content.push(tr)
 








  const onCancel = () => {
    newSettingsForCategory = {};
    editBtn.class = 'category-header_edit-btn_not-selected'
  }

  const onAccept = () => {
    const inputForChangingCategoryTitle = document.getElementById('inputForChangingCategoryTitle');
    if (inputForChangingCategoryTitle) {
      newSettingsForCategory.newCategoryTitle = inputForChangingCategoryTitle.value
    }

    executeEditCategory(category);
    editBtn.class = 'category-header_edit-btn_not-selected'
    hideGeneralModal();
  }

  renderGeneralModal({
    label: "Edit category: " + category.description.replace('&nbsp', ' '),
    content,
    onCancel: {
      render: true,
      label: "Cancel",
      method: onCancel,
    },
    onAccept: {
      render: true,
      label: "Accept",
      method: onAccept
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_edit-category"
  })
};



function attachDropDownOfCategoriesForEditingCategory(currentCategory) {
  const numCategories = dbBioRobot.categories.length;
  for (let i = numCategories - 1; i >= 0; i--) {
    if (currentCategory.id !== dbBioRobot.categories[i].id) {
      tr = newTr();
      tr.className = 'removeAfterPickingNewCategory'
      td = newTd();
      td.className = 'bcwhite';
      td.style.border = 'none';
      td.colSpan = 2;
      tr.appendChild(td)

      td = newTd(dbBioRobot.categories[i].description.replaceAll('&nbsp;', ' '));
      td.id = dbBioRobot.categories[i].id;
      td.className = 'taskEditCat';
      td.addEventListener('click', () => {
        newSettingsForCategory.copyTasksFromThisCategory = dbBioRobot.categories[i];

        // Remove dropdown
        removeElementsByClass('removeAfterPickingNewCategory')
        // Reapply dropdown options
        var elem = document.getElementById('placeHolderCategory');
        // Fill text field with newly chosen category
        elem.innerHTML = dbBioRobot.categories[i].description.replaceAll('&nbsp;', ' ');

        // Reapply dropdown options
        elem.addEventListener('click', () => {
          // Remove eventlisteners
          var elem = document.getElementById('placeHolderCategory');
          elem.replaceWith(elem.cloneNode(true));
          // Race condition sets need for 2nd time
          var elem2 = document.getElementById('placeHolderCategory');
          elem2.className = 'bcHotpink bgHotpinkcCornBlue'
          attachDropDownOfCategoriesForEditingCategory(dbBioRobot.categories[i])
        });

      });
      tr.appendChild(td)
      const place = document.getElementById('placeCategoryDropDownOptionsAfterThis');
      place.after(tr)
    }
  }
}


function executeEditCategory(category) {
  // console.log('execute:', category)
  // console.log('new settings:', newSettingsForCategory)

  if (newSettingsForCategory.newCategoryTitle) {
    category.description = newSettingsForCategory.newCategoryTitle;
  }

  if (newSettingsForCategory.copyTasksFromThisCategory) {
    // Create new list of tasks to be copied and added after changing id's
    const tasksCopiedToCategory = [];
    dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
      if (task.category === newSettingsForCategory.copyTasksFromThisCategory.id) {
        // Copy not reference
        let deepcopy = JSON.parse(JSON.stringify(task));
        tasksCopiedToCategory.push(deepcopy);
      }
    });
    tasksCopiedToCategory.forEach((taskToCopy, index) => {
      taskToCopy.uid = 'uid' + new Date().getTime() + index;
      taskToCopy.category = category.id;
      dbBioRobot.tasksToBeExecuted.push(taskToCopy)
    })
  }

  if (newSettingsForCategory.changeOrder) {
    // Delete task on previous location to insert in new location
    let indexOfCategory = 0;
    dbBioRobot.categories.forEach((cat, index) => {
      if (cat.id === category.id) {
        console.log('index = ', index)
        indexOfCategory = index;
      }
    })
    dbBioRobot.categories.splice(indexOfCategory, 1);

    if (newSettingsForCategory.changeOrder === 'bottom') {
      // Move task to bottom of list
      dbBioRobot.categories.push(category);
    } else if (newSettingsForCategory.changeOrder === 'top') {

      // Move task to top of list
      dbBioRobot.categories.unshift(category);
    }
  }

  if (newSettingsForCategory.highlight) {
    let indexOfCategory = 0;
    dbBioRobot.categories.forEach((cat, index) => {
      if (cat.id === category.id) {
        console.log('index = ', index)
        indexOfCategory = index;
      }
    })
    dbBioRobot.categories[indexOfCategory].highlight = newSettingsForCategory.highlight;
  }



  // console.log('sla deze op = ', dbBioRobot)
  updateLocalStorage(dbBioRobot);
  renderTasks();
  renderCategoryButtons();
  setCategory(window.localStorage['taskCategoryId'])

}



const openSettingsMenu = () => {
  const newSettingsForSettingsMenu = window.localStorage['settings_menu']
    ? JSON.parse(window.localStorage['settings_menu'])
    : { 
        actionBarOnTop: true,
        showHeader: true  
      };



  const content = [];

  // ROW for setting category first or last
  let tr = newTr();
  // CELL
  let td = newTd('Where do you want the Action Bar?');
  td.className = '';
  td.style.textAlign = 'right'
  td.rowSpan = 2;
  td.colSpan = 2;
  tr.appendChild(td);

  // CELL
  td = newTd('On top of page');
  td.className = newSettingsForSettingsMenu.actionBarOnTop
    ? 'modal_set-top-or-bottom modal_set-top-or-bottom_selected'
    : 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected'
  td.id = 'btnShowActionBarOnTop';
  td.colSpan = 2;
  td.onclick = () => {
    const btnShowActionBarOnBottom = document.getElementById('btnShowActionBarOnBottom');
    const btnShowActionBarOnTop = document.getElementById('btnShowActionBarOnTop');
    if (newSettingsForSettingsMenu.actionBarOnTop == false) {
      newSettingsForSettingsMenu.actionBarOnTop = true;
      btnShowActionBarOnTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_selected';
      btnShowActionBarOnBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    }
  }
  tr.appendChild(td);
  content.push(tr)

  // ROW
  tr = newTr();
  // CELL
  td = newTd('On bottom of page');
  td.className = newSettingsForSettingsMenu.actionBarOnTop
    ? 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected'
    : 'modal_set-top-or-bottom modal_set-top-or-bottom_selected'
  td.colSpan = 2;
  td.id = 'btnShowActionBarOnBottom';
  td.onclick = () => {
    const btnShowActionBarOnBottom = document.getElementById('btnShowActionBarOnBottom');
    const btnShowActionBarOnTop = document.getElementById('btnShowActionBarOnTop');
    if (newSettingsForSettingsMenu.actionBarOnTop == true) {
      newSettingsForSettingsMenu.actionBarOnTop = false;
      btnShowActionBarOnTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
      btnShowActionBarOnBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_selected';
    } 
  }
  tr.appendChild(td);
  content.push(tr)
  



  const onCancel = () => {
  }

  const onAccept = () => {
    window.localStorage['settings_menu'] = JSON.stringify(newSettingsForSettingsMenu);
    executeSettings(newSettingsForSettingsMenu);
    hideGeneralModal();

  }

  renderGeneralModal({
    label: "Settings Menu",
    content,
    onCancel: {
      render: true,
      label: "Cancel",
      method: onCancel,
    },
    onAccept: {
      render: true,
      label: "Accept",
      method: onAccept
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_settings"
  })
}

const executeSettings = (newSettingsForSettingsMenu) => {
  // console.log('executeSettings', newSettingsForSettingsMenu)
  const actionBar = document.getElementById('action-bar')
  const categoryContainer = document.getElementById('categoryContainer')
  const body = document.getElementById('body');

  newSettingsForSettingsMenu.actionBarOnTop
    ? body.insertBefore(actionBar, categoryContainer)
    : body.insertBefore(categoryContainer, actionBar)


}

// Execute settings on startup
const executeSettingsOnStartUp = () => {
  if(window.localStorage['settings_menu']) {
    const newSettingsForSettingsMenu = JSON.parse(window.localStorage['settings_menu'])
    executeSettings(newSettingsForSettingsMenu)
  } else {
    console.log(2222222)

  }
}
executeSettingsOnStartUp()









// Mark checkbox of an task (does nothing besides this)
function markCheckBox(id) {
  let indexToAdjust = null;
  dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
    if (task && task.uid === id.id) {
      indexToAdjust = index;
    }
  })
  dbBioRobot.tasksToBeExecuted[indexToAdjust].checked = !dbBioRobot.tasksToBeExecuted[indexToAdjust].checked;
  updateLocalStorage(dbBioRobot);
  renderTasks()
}


// Remove task from db.tasksToBeExecuted and insert into db.taskForHistory
function markTaskAsDone(uid) {
  // console.log('recieved id = ',uid);
  let indexToDelete = null;
  dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
    if (task && task.uid === uid) {
      indexToDelete = index;
    }
  })
  const taskForHistory = {
    title: dbBioRobot.tasksToBeExecuted[indexToDelete].title,
    uid: dbBioRobot.tasksToBeExecuted[indexToDelete].uid,
    category: dbBioRobot.tasksToBeExecuted[indexToDelete].category,
    timeStampExecuted: new Date(),
  }
  dbBioRobot.tasksHistory.push(taskForHistory);

  const transaction = {
    timeStamp: new Date(),
    category: dbBioRobot.tasksToBeExecuted[indexToDelete].category,
  }
  dbBioRobot.tasksToBeExecuted.splice(indexToDelete, 1)
  updateLocalStorage(dbBioRobot);
  renderTasks()
}


// Remove task from db.tasksToBeExecuted and insert into db.taskForHistory
function deleteTask(id, erase = false) {
  // console.log('deleteTask recieved id = ',id);
  let indexToDelete = null;
  dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
    if (task && task.uid === id) {
      indexToDelete = index;
    }
  })
  const taskFound = dbBioRobot.tasksToBeExecuted[indexToDelete]
  console.log('this = ', taskFound)
  // console.log('indexToDelete = ', dbBioRobot.tasksToBeExecuted[indexToDelete] );
  if (!erase) {
    dbBioRobot.tasksDeleted.push(taskFound);
  }
  dbBioRobot.tasksToBeExecuted.splice(indexToDelete, 1)
  updateLocalStorage(dbBioRobot);
  renderTasks()
}


// Change order of tasks in DB
function moveTaskUpOrDown(direction, uid) {
  // get task to move
  let taskToMove = {};
  let indexOfTaskToMove = 0;
  dbBioRobot.tasksToBeExecuted.forEach((task, index) => {
    if (task && task.uid === uid.id) {
      taskToMove = dbBioRobot.tasksToBeExecuted[index];
      indexOfTaskToMove = index;
    }
  })
  // console.log('Move this task = ', taskToMove)
  // console.log('it has index = ', indexOfTaskToMove)

  if (direction === 'up') {
    // loop backwards trough db.tasksToBeExecuted to find closest downstream sibling
    // (task same cat. & lower index then current)
    let indexOfNewPlace = 0;

    for (i = 0; i < indexOfTaskToMove; i++) {
      if (dbBioRobot.tasksToBeExecuted[i] && dbBioRobot.tasksToBeExecuted[i].category === taskToMove.category) {
        indexOfNewPlace = i;
      }
    }
    // switch places
    dbBioRobot.tasksToBeExecuted.splice(indexOfNewPlace, 0, taskToMove);
    // Remove task to move from old location
    dbBioRobot.tasksToBeExecuted.splice((indexOfTaskToMove + 1), 1);
    // store db & update screen
    updateLocalStorage(dbBioRobot);
    renderTasks();
  }
  else {
    // loop forward trough db.tasksToBeExecuted to find closest upstream sibling
    // (task same cat. & higher index then current)
    let indexOfNewPlace = 0;
    for (i = indexOfTaskToMove + 1; i < dbBioRobot.tasksToBeExecuted.length; i++) {
      if (dbBioRobot.tasksToBeExecuted[i].category === taskToMove.category) {
        indexOfNewPlace = i;
        // switch places
        dbBioRobot.tasksToBeExecuted.splice((indexOfNewPlace + 1), 0, taskToMove);
        // Remove task to move from old location
        dbBioRobot.tasksToBeExecuted.splice(indexOfTaskToMove, 1);
        // store & update screen
        updateLocalStorage(dbBioRobot);
        renderTasks();
        break;
      };
    };
  };
};




// Check if task is the first task within it's category
function taskIsFirstWithinItsCategory(taskToCheck) {
  const arrTasksWithSameCategory = dbBioRobot.tasksToBeExecuted.filter(task => task.category === taskToCheck.category);
  const indexOfTaskToCheck = arrTasksWithSameCategory.findIndex(task => task.uid === taskToCheck.uid)
  if (indexOfTaskToCheck === 0) {
    return true;
  }
  return false;
}

// Edit properties of task
let newSettingsForTask = {};


// editTask({
//   category: "uid1659347236218",
//   title: "\nadd varnish over glitters to prevent glitter colours mixin",
//   uid: "uid1659347259283"
// })


function editTask(task) {
  // console.log('Edit task = ', task);

 

  
  newSettingsForTask = {};

  const currentCategory = dbBioRobot.categories.find(cat => cat.id === task.category);

  // CSS on edit btn in task
  const editBtn = document.getElementById('taskEditUidIs' + task.uid)
  editBtn.class = 'task_edit-btn-selected'
 
  const content = [];


 
  // ROW for editing order of task
  tr = newTr();
  // CELL
  td = newTd('Change order of Task');
  td.style.textAlign = 'right'
  td.className = '';
  td.rowSpan = 2;
  td.colSpan = 2;
  tr.appendChild(td);
  // CELL
  td = newTd('Set task first');
  td.colSpan = 2;
  td.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
  td.id = 'btnMoveTaskToTop';
  td.onclick = () => {
    const btnMoveTaskToBottom = document.getElementById('btnMoveTaskToBottom');
    const btnMoveTaskToTop = document.getElementById('btnMoveTaskToTop');
    if (newSettingsForTask.changeOrder === undefined || newSettingsForTask.changeOrder === 'bottom') {
      newSettingsForTask.changeOrder = 'top';
      btnMoveTaskToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
      btnMoveTaskToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_selected';
    } else {
      newSettingsForTask.changeOrder = undefined;
      btnMoveTaskToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
      btnMoveTaskToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    }
  }
  tr.appendChild(td);
  content.push(tr);


  // ROW
  tr = newTr();
  // CELL
  td = newTd('Set task last');
  td.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
  td.colSpan = 2;
  td.id = 'btnMoveTaskToBottom';
  td.onclick = () => {
    const btnMoveTaskToBottom = document.getElementById('btnMoveTaskToBottom');
    const btnMoveTaskToTop = document.getElementById('btnMoveTaskToTop');
    if (newSettingsForTask.changeOrder === undefined || newSettingsForTask.changeOrder === 'top') {
      newSettingsForTask.changeOrder = 'bottom';
      btnMoveTaskToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_selected';
      btnMoveTaskToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    } else {
      newSettingsForTask.changeOrder = undefined;
      btnMoveTaskToBottom.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
      btnMoveTaskToTop.className = 'modal_set-top-or-bottom modal_set-top-or-bottom_not-selected';
    }
  }
  tr.appendChild(td);
  content.push(tr);

  
 


  // Edit task title
  // ROW
  tr = newTr();
  // CELL
  td = newTd('Edit title');
  td.className = 'bcwhite cSilver';
  td.style.textAlign = 'right'
  td.colSpan = 2;
  tr.appendChild(td);
  // CELL
  td = newTd();
  td.className = '';
  td.colSpan = 2;

  let input = document.createElement('textarea');
  input.id = 'inputForChangingTaskTitle';
  input.className = 'inputForChangingTaskTitle';
  input.value = task.title;

  td.appendChild(input)
  tr.appendChild(td);
  content.push(tr);


  // Add link in task

  // link label
  // ROW
  tr = newTr();
  // CELL
  td = newTd('Link label');
  td.className = ' ';
  td.style.textAlign = 'right'
  td.colSpan = 2;
  tr.appendChild(td);
  // CELL
  td = newTd();
  td.className = '';
  td.colSpan = 2;

  input = document.createElement('input');
  input.id = 'inputForTaskLinkLabel';
  input.className = 'inputForTaskLinkLabel';
  if (task.linkLabel) {
    input.value = task.linkLabel;
  }
  input.placeholder = "Add label for link";
  td.appendChild(input)
  tr.appendChild(td);
  content.push(tr);

  // link url
  // ROW
  tr = newTr();
  // CELL
  td = newTd('Link URL');
  td.className = ' ';
  td.style.textAlign = 'right'
  td.colSpan = 2;
  tr.appendChild(td);
  // CELL
  td = newTd();
  td.className = '';
  td.colSpan = 2;

  input = document.createElement('input');
  input.id = 'inputForTaskLinkURL';
  input.className = 'inputForTaskLinkURL';
  if (task.linkURL) {
    input.value = task.linkURL;
  }
  input.placeholder = "Add URL for link";
  td.appendChild(input)
  tr.appendChild(td);
  content.push(tr);






  // Change category
  // ROW
  tr = newTr();
  // CELL
  tr.id = 'placeCategoryDropDownOptionsAfterThis'
  td = newTd('Change category');
  td.className = '';
  td.colSpan = 2;
  td.style.textAlign = 'right'
  tr.appendChild(td);
  // CELL
  // Current category as placeholder / default
  td = newTd(currentCategory.description);
  td.className = '';
  td.colSpan = 4;
  td.id = 'placeHolderCategory'
  td.addEventListener('click', () => {
    // Remove eventlisteners
    var elem = document.getElementById('placeHolderCategory');
    elem.replaceWith(elem.cloneNode(true));
    // Race condition sets need for 2nd time
    var elem2 = document.getElementById('placeHolderCategory');
    elem2.className = 'bcHotpink bgHotpinkcCornBlue'
    attachDropDownOfCategoriesForEditingTask(currentCategory)
  });
  tr.appendChild(td);
  content.push(tr);




  const onCancel = () => {
    newSettingsForTask = {};
  }
  const onAccept = () => {
    const inputForChangingTaskTitle = document.getElementById('inputForChangingTaskTitle')
    task.title = inputForChangingTaskTitle.value;
    executeEditTask(task);
    hideGeneralModal();
  
  }


  renderGeneralModal({
    label: "Edit task: " + task.title.replace('&nbsp', ' '),
    content,
    onCancel: {
      render: true,
      label: "Cancel",
      method: onCancel,
    },
    onAccept: {
      render: true,
      label: "Accept",
      method: onAccept
    },
    canClickOutside: true,
    canClickEscapeKey: true,
    className: "modal_edit-task"
  })
};




function attachDropDownOfCategoriesForEditingTask(currentCategory) {
  const numCategories = dbBioRobot.categories.length;
  for (let i = numCategories - 1; i >= 0; i--) {
    if (currentCategory.id !== dbBioRobot.categories[i].id) {
      tr = newTr();
      tr.className = 'removeAfterPickingNewCategory'
      td = newTd();
      td.className = '';
      td.colSpan = 2;
      td.style.border = "none"
      tr.appendChild(td)

      td = newTd(dbBioRobot.categories[i].description.replaceAll('&nbsp;', ' '));
      td.id = dbBioRobot.categories[i].id;
      td.className = 'taskEditCat';
      td.addEventListener('click', () => {
        newSettingsForTask.newCategory = dbBioRobot.categories[i];
        // Remove dropdown
        removeElementsByClass('removeAfterPickingNewCategory')
        // Reapply dropdown options
        var elem = document.getElementById('placeHolderCategory');
        // Fill text field with newly chosen category
        elem.innerHTML = dbBioRobot.categories[i].description.replaceAll('&nbsp;', ' ');

        // Reapply dropdown options
        elem.addEventListener('click', () => {
          // Remove eventlisteners
          var elem = document.getElementById('placeHolderCategory');
          elem.replaceWith(elem.cloneNode(true));
          // Race condition sets need for 2nd time
          var elem2 = document.getElementById('placeHolderCategory');
          elem2.className = ''
          attachDropDownOfCategoriesForEditingTask(dbBioRobot.categories[i])
        });

      });
      tr.appendChild(td)
      const place = document.getElementById('placeCategoryDropDownOptionsAfterThis');
      place.after(tr)
    }
  }
}

function removeElementsByClass(className) {
  var elements = document.getElementsByClassName(className);
  while (elements.length > 0) {
    elements[0].parentNode.removeChild(elements[0]);
  }
}

function newTr() {
  return document.createElement('tr');
};
function newTd(textNode = '') {
  const td = document.createElement('td')
  const tn = document.createTextNode(textNode)
  td.appendChild(tn);
  return td;
};


function executeEditTask(task) {
  // console.log('execute:', task)
  // const currentCategory = dbBioRobot.categories.find(cat => cat.id === task.category);

  // console.log('new settings:', newSettingsForTask)
 
  const inputForTaskLinkLabel = document.getElementById('inputForTaskLinkLabel')
  const inputForTaskLinkURL = document.getElementById('inputForTaskLinkURL')
  if (inputForTaskLinkURL && inputForTaskLinkURL.value) {
    task.linkLabel = inputForTaskLinkLabel.value || "Link";
    task.linkURL = inputForTaskLinkURL.value;
  }
  if (newSettingsForTask.newTaskTitleTextArea) {
      task.title = newSettingsForTask.newTaskTitleTextArea;
  }

  if (newSettingsForTask.newCategory) {
    task.category = newSettingsForTask.newCategory.id;
  }

  // Store the changes before you change order of tasks
  dbBioRobot.tasksToBeExecuted.forEach((x, index) => {
    if (x.uid === task.uid)
      dbBioRobot.tasksToBeExecuted[index] = task;
  });

  if (newSettingsForTask.changeOrder || newSettingsForTask.newCategory) {
    // Delete task on previous location to insert in new location
    deleteTask(task.uid, true)
    if (newSettingsForTask.changeOrder === 'bottom') 
      // Move task to bottom of list
      dbBioRobot.tasksToBeExecuted.push(task);
    else 
      // Move task to top of list
      dbBioRobot.tasksToBeExecuted.unshift(task);
  
  }

  updateLocalStorage(dbBioRobot);
  renderTasks()
}




// todo option scrollto param but not sure if desired
// scrollTo({  top: 0,  behavior: 'smooth'});
// content is a single string, or an array of table rows
function renderGeneralModal({ label, content, onCancel, onAccept, canClickOutside, canClickEscapeKey, className }) {
  lockOverlay.style.display = "inherit";
  modal.style.display = "inherit";
  modal.className = "modal " + className;

  // Render modal in current position vertically on page
  const x = window.scrollX;
  const y = window.scrollY;
  modal.style.top = 'calc(10vh + ' + y + 'px)';
  modal.style.left = 'calc(50vw - ' + (modal.clientWidth / 2) + 'px)';

  // lockOverlay.style.top = y + 'px';


  let tr = newTr();
  let td = newTd(label);
  td.colSpan = 4;
  td.className = "modal_label";
  tr.appendChild(td)
  modal.append(tr)


    tr = newTr();
    td = newTd();
    td.colSpan = 4;
    td.className = "modal_warning";
    td.id = "modal_warning";
    tr.appendChild(td)
    modal.append(tr)  
  

  tr = newTr();
  if (typeof content == "string") {
    td = newTd(content);
    td.className = "modal_content-string";
    td.colSpan = 4;
    tr.appendChild(td)
    modal.append(tr)
  }

  if (Array.isArray(content)) {
    content.forEach(tableRow => {
      modal.append(tableRow)
    })
  }

  if (onCancel.render | onAccept.render) {
    tr = newTr();
    if (onCancel.render) {
      td = newTd(onCancel.label);
      td.colSpan = 2;
      td.className = "modal_cancel";
      td.onclick = () => {
        onCancel.method();
        hideGeneralModal();
      }
      tr.appendChild(td)  
    }
    if (onAccept.render) {
      td = newTd(onAccept.label);
      td.colSpan = 2;
      td.className = "modal_accept";
      td.onclick = () => {
        onAccept.method();
      }
      tr.appendChild(td)  
    }
    modal.append(tr)
  }

  if (canClickOutside) {
    lockOverlay.addEventListener('click', () => {
      hideGeneralModal();
    })
    if (onCancel.method) onCancel.method
  }
  if (canClickEscapeKey) {
    document.onkeydown = function(evt) {
      evt = evt || window.event;
      var isEscape = false;
      if ("key" in evt) {
          isEscape = (evt.key === "Escape" || evt.key === "Esc");
      } else {
          isEscape = (evt.keyCode === 27);
      }
      if (isEscape) {
        hideGeneralModal();
        if (onCancel.method) onCancel.method
      }
    };
  }
}



function hideGeneralModal() {
  lockOverlay.style.display = 'none';
  modal.style.display = "none";
  modal.innerHTML = "";
  modal.className = "modal";
}


// todo edit this after modal shift is done

// Clicking on lockoverlay makes modals disappear
lockOverlay.onclick = () => {
  // this is used to keep the pressed btn highlighted / hover mode while model is open
  // document.getElementById('deleteDB').className = 'btnactionbar-renamedcheckthis ';
  lockOverlay.style.display = 'none';
}












// todo option scrollto param but not sure if desired
// scrollTo({  top: 0,  behavior: 'smooth'});
// content is a single string, or an array of table rows
function renderToast({label, content, className}) {
  lockOverlay.style.display = "inherit";
  toast.style.display = "inherit";
  toast.className = "modal " + className;

  let tr = newTr();
  let td = newTd(label);
  td.colSpan = 4;
  td.className = "modal_label";
  tr.appendChild(td)
  toast.append(tr)


    tr = newTr();
    td = newTd();
    td.colSpan = 4;
    td.className = "modal_warning";
    td.id = "modal_warning";
    tr.appendChild(td)
    toast.append(tr)  
  

  tr = newTr();
  if (typeof content == "string") {
    td = newTd(content);
    td.className = "modal_content-string";
    td.colSpan = 4;
    tr.appendChild(td)
    toast.append(tr)
  }

  if (Array.isArray(content)) {
    content.forEach(tableRow => {
      toast.append(tableRow)
    })
  }

  setTimeout(() => {
    toast.innerHTML = "";
    toast.style.display = 'none';
    lockOverlay.style.display = "none";
  }, 3000)

 

}





const oldest =

{
	"categories": [{
		"id": "General",
		"description": "General"
	}],
	"tasksToBeExecuted": [
		{
			"title": "older",
			"uid": "uid161072254sdfdg2572sfdgf",
			"category": "General",
			"checked": true
		}
	],
	"tasksHistory": [],
	"tasksDeleted": []
}

let newest =
 {
	"categories": [{
		"id": "General",
		"description": "GeneralotherName"
	},
	{
		"id": "new",
		"description": "new cat"
	}
	],
	"tasksToBeExecuted": [
    {
			"title": "older with different title",
			"uid": "uid161072254sdfdg2572sfdgf",
			"category": "General",
			"checked": true
		},
		{
			"title": "from other db",
			"uid": "uid161072254sdfdg2572",
			"category": "General",
			"checked": true
		}
	],
	"tasksHistory": [],
	"tasksDeleted": []
}






function getRandomInt(max) {
  let min = 0;
    min = Math.ceil(min);
    max = Math.floor(max);
    let rand = Math.floor(Math.random() * (max - min + 1)) + min;
    
    // rand = Math.floor(Math.random() * 100000000000000000000000);
    rand = Math.floor(Math.random() * 1000000000000);
    console.log('thisis random = ', rand)
    return rand;
}


const mergeDatabases = (newDatabase) => {
  // console.log('mergin = ', dbBioRobot)
  // console.log('with this = ', newDatabase)
  console.log('mergeDatabases ')

  newDatabase.categories.forEach(newCategoryToBeInserted => {
    let identicalCategoryIDFound = false;
    let identicalCategoryTitleFound = false;
    // console.log('mergeDatabases loop for new cat ========',newCategoryToBeInserted)

    dbBioRobot.categories.forEach(categoryAlreadyInCurrentDB => {
      // console.log('compare 1', categoryAlreadyInCurrentDB.id)
      // console.log('compare 2', newCategoryToBeInserted.id)
      if (categoryAlreadyInCurrentDB.id == newCategoryToBeInserted.id)
        identicalCategoryIDFound = true;
      if (categoryAlreadyInCurrentDB.description == newCategoryToBeInserted.description)
        identicalCategoryTitleFound = true;
    })
    if (!identicalCategoryIDFound) {
      // console.log('no identical cat found old ', categoryAlreadyInCurrentDB)
      // console.log('no identical cat found new ', newCategoryToBeInserted)
      dbBioRobot.categories.push(newCategoryToBeInserted);
    } else if (identicalCategoryIDFound && !identicalCategoryTitleFound) {
        // If the category id was found, but the titles are not the same, just change id and add category
        newCategoryToBeInserted.id = 'uid' + getRandomInt(100000000000000000000000);
        dbBioRobot.categories.push(newCategoryToBeInserted);
    }
  })

  newDatabase.tasksToBeExecuted.forEach(newTaskToBeInserted => {
    let identicalTaskIDFound = false;
    let identicalTaskTitleFound = false;
    dbBioRobot.tasksToBeExecuted.forEach(taskAlreadyInCurrentDB => {
      // console.log('checking old task = ', taskAlreadyInCurrentDB)
      if (taskAlreadyInCurrentDB.id == newTaskToBeInserted.id)
        identicalTaskIDFound = true;
      if (taskAlreadyInCurrentDB.title == newTaskToBeInserted.title)
        identicalTaskTitleFound = true;
      // console.log('identicalTaskIDFound is now = ', identicalTaskIDFound)
      // console.log('identicalTaskTitleFound is now = ', identicalTaskTitleFound)
    })

    if (!identicalTaskIDFound) {
      dbBioRobot.tasksToBeExecuted.push(newTaskToBeInserted);
    } else if (identicalTaskIDFound && !identicalTaskTitleFound) {
        // If the task id was found, but the titles are not the same, just change id and add task
        newTaskToBeInserted.uid = 'uid' + getRandomInt(100000000000000000000000);
        dbBioRobot.tasksToBeExecuted.push(newTaskToBeInserted);
    }
  })
  

  // Bin and history don't need to be merged

}


const replaceSpecialChars = (string) => {
  // return string;

  string = string.replaceAll("'", "-single quotation-")
 // string = string.replaceAll('"', "-double quotation-")
  string = string.replaceAll("&", "-ampersand-")
  string = string.replaceAll("/", "-forward slash-")
  string = string.replaceAll("/\\/", "-backward slash-")
  // string = String.raw`${string}`.replaceAll(/\\/g,"\\\\")
  return string;
}


// MERGE LARGE QUANTITY OF JSON DATABASES
// NAME JSON FILES IN ASCENDING ORDER

// First put them in a list for async reasons
let listOfAllNewDatabases = [];
/*

for(i=1; i< 82; i++) {
// for(i=1; i< 3; i++) {
  fetch('./_sungymdbmergegame/' + i + '.json')
    .then(response => response.json())
    .then(data => {
      console.log(data)
      listOfAllNewDatabases.push(data)
    })
    .catch(error => {
      console.log('catch i = ', i )
      console.log(error)
    });
}

setTimeout(() => {
  console.log('listOfAllNewDatabases length = ', listOfAllNewDatabases.length)
  console.log('listOfAllNewDatabases = ', listOfAllNewDatabases)
  
  let counter = 0;
  let mergeInterval = setInterval(()=> {
    console.log('##### interval new set = ', counter)
    console.log('interval data total = ', dbBioRobot.tasksToBeExecuted.length)
    mergeDatabases(listOfAllNewDatabases[counter]);
    counter ++;  

    if(counter == listOfAllNewDatabases.length) {
      clearInterval(mergeInterval)
      updateLocalStorage(dbBioRobot);
      renderTasks()
      renderCategoryButtons();    
    }
    console.log('##### interval end set = ', counter)
    updateLocalStorage(dbBioRobot);
    renderTasks()
    renderCategoryButtons();    
    console.log('READY AND NEW = ', dbBioRobot)
  }, 6000)
}, 6000)


*/




</script>

