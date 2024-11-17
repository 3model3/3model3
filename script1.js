// Declare variables to store references to HTML elements
let expenseList = document.getElementById("expense-list");
let incomeList = document.getElementById("income-list");
let total = document.getElementById("total");
let expenseForm = document.getElementById("expense-form");
let description = document.getElementById("description");
let amount = document.getElementById("amount");
let type = document.getElementById("type");
let btnAdd = document.getElementById("btn-add");
let btnClearIncomes = document.getElementById("btn-clear-income");
let btnClearExpenses = document.getElementById("btn-clear-expense");

// Initialize arrays and variables for expenses and incomes
let expenses = [];
let incomes = [];
let totalExpenses = 0;
let totalIncomes = 0;

// Add event listener to the button add when clicked
btnAdd.addEventListener("click", function(){

    // Create an object to represent the expense / income
    let dataValues = { description:description.value,
                       amount: parseFloat(amount.value),
                       type:type.value 
                    };

    // If the expense / income has a description and amount, add it to the appropriate array               
    if(dataValues.description && dataValues.amount){

         if(dataValues.type === "expense"){
             expenses.push(dataValues);
             totalExpenses += dataValues.amount;
         }
         else
         {
           incomes.push(dataValues);
           totalIncomes += dataValues.amount;
         }

        // Clear the description and amount input fields, then update the lists and total
        description.value = "";
        amount.value = "";
        updateLists();
        updateTotal();
         
    }

});


// Function to update the HTML lists of expenses and incomes
function updateLists(){
 // Clear the lists 
    expenseList.innerHTML = "";
    incomeList.innerHTML = "";


/* Loop through the expenses and incomes arrays and add each one to its 
   respective list as an HTML <li> element */
    expenses.forEach(function(expense){
 
        let li = document.createElement("li");
        li.innerHTML = expense.description + ": $" + expense.amount;
        expenseList.appendChild(li);
    });

    incomes.forEach(function(income){
 
        let li = document.createElement("li");
        li.innerHTML = income.description + ": $" + income.amount;
        incomeList.appendChild(li);
    });
}

// Function to update the total income and expenses and display the result
function updateTotal()
{
    total.innerHTML = "";
    let netIncome = totalIncomes - totalExpenses;

/* Display the net income with a minus sign if it's negative, 
   otherwise display it as a positive value */
    if(netIncome < 0){
        total.innerHTML = "-$" + -netIncome;
    }
    else{
        total.innerHTML = "$" + netIncome;
    }
    


    // Hide the clear buttons if there are no expenses or incomes, otherwise show them
    if(expenseList.children.length == 0 ){
        btnClearExpenses.style.display = "none";
    }else{
        btnClearExpenses.style.display = "block"; 
    }

    if(incomeList.children.length == 0 ){
        btnClearIncomes.style.display = "none";
    }else{
        btnClearIncomes.style.display = "block"; 
    }


}



// Add event listeners to the clear buttons for expenses and incomes
btnClearExpenses.addEventListener("click", function(){

    expenses = [];
    totalExpenses = 0;
    updateLists();
    updateTotal();

});

btnClearIncomes.addEventListener("click", function(){

    incomes = [];
    totalIncomes = 0;
    updateLists();
    updateTotal();

});









