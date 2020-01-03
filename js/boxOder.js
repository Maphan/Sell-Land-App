// JavaScript Document
function UI_list() {
  var myButtonClasses = document.getElementById("products").classList;
  var myBtnList = document.getElementById("list_btn").classList;
  var myBtnGrid = document.getElementById("grid-btn").classList;
	
  if (myButtonClasses.contains("box_oder-list")) {
  } else {
	myButtonClasses.remove("box_oder-grid");
    myButtonClasses.add("box_oder-list");
	myBtnGrid.remove("active");
	myBtnList.add("active");
  }
}
function UI_grid() {
  var myButtonClasses = document.getElementById("products").classList;
  var myBtnList = document.getElementById("list_btn").classList;
  var myBtnGrid = document.getElementById("grid-btn").classList;
	
  if (myButtonClasses.contains("box_oder-grid")) {
  } else {
	myButtonClasses.remove("box_oder-list");
    myButtonClasses.add("box_oder-grid");
	myBtnList.remove("active");
	myBtnGrid.add("active");
  }
}