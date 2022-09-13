function calculateIndex(){
    var weight = document.bodyCalculator.weight.value;
    var height = document.bodyCalculator.height.value;
    if(height > 1 && weight > 1){
        var result = weight / (height * height / 10000);
        document.bodyCalculator.bodyIndexData.value = result.toFixed(2);
        if(result < 18.49){
            document.bodyCalculator.calculatedResult.value = "You are underweight.";
        }
        if(result > 18.49 && result < 24.99){
            document.bodyCalculator.calculatedResult.value = "You are normal weight.";
        }
        if(result > 24.99 && result < 29.99){
            document.bodyCalculator.calculatedResult.value = "You are overweight.";
        }
        if(result > 29.99 && result < 34.99){
            document.bodyCalculator.calculatedResult.value = "You are 1st degree obese.";
        }
        if(result > 34.99 && result < 39.99){
            document.bodyCalculator.calculatedResult.value = "You are 2nd degree obese.";
        }
        if(result > 39.99){
            document.bodyCalculator.calculatedResult.value = "You are 3rd degree obese.";
        }
    }
    else{
        document.bodyCalculator.calculatedResult.value = "Please fill the all areas.";
    }
}
function fcs(el){
    if(el.value === el.defaultValue){
        el.value = "";
        el.setAttribute("class","col2");
    }else if(el.value === ""){
        el.value = el.defaultValue;
        el.setAttribute("class","col2");
    }
}