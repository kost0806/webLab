"use strict"
window.onload = function () {
    var stack = [];
    var displayVal = "0";
    $("expression").innerHTML = "";
    for (var i in $$('button')) {
        $$('button')[i].onclick = function () {
            var value = this.innerHTML;
            if (value == "AC") {
                displayVal = '0';
                stack = [];
            }
            else if (value == ".") {
                var flag = false;
                for (var i = 0; i < displayVal.length; ++i) {
                    if (displayVal[i] == '.') {
                        flag = true;
                        break;
                    }
                }
                if (!flag) {
                    displayVal += ".";
                    $("expression").innerHTML += value;
                }
            }
            else if (value == "!") {
                var ex = $("expression").innerHTML;
                if (ex[ex.length - 1] != '!') {
                    $("expression").innerHTML += value;
                    // stack.push(factorial(parseFloat(displayVal)));
                    // displayVal = '0';
                    displayVal = factorial(parseFloat(displayVal));
                }
            }
            else if (value == "/") {
                $("expression").innerHTML += value;
                stack.push(parseFloat(displayVal));
                stack.push(value);
                displayVal = '0';
            }
            else if (value == "*") {
                $("expression").innerHTML += value;
                stack.push(parseFloat(displayVal));
                stack.push(value);
                displayVal = '0';
            }
            else if (value == "^") {
                $("expression").innerHTML += value;
                stack.push(parseFloat(displayVal));
                stack.push(value);
                displayVal = '0';
            }
            else if (value == "-") {
                $("expression").innerHTML += value;
                if (stack[stack.length - 1] == '*' || stack[stack.length - 1] == '/' || stack[stack.length - 1] == '^') {
                    highPriorityCalculator(stack, parseFloat(displayVal));
                }
                else
                    stack.push(parseFloat(displayVal));
                stack.push(value);
                displayVal = '0';
            }
            else if (value == "+") {
                $("expression").innerHTML += value;
                if (stack[stack.length - 1] == '*' || stack[stack.length - 1] == '/' || stack[stack.length - 1] == '^') {
                    highPriorityCalculator(stack, parseFloat(displayVal));
                }
                else
                    stack.push(parseFloat(displayVal));
                stack.push(value);
                displayVal = '0';
            }
            else if (value == "=") {
                $("expression").innerHTML += value;
                if (stack[stack.length - 1] == '*' || stack[stack.length - 1] == '/' || stack[stack.length - 1] == '^') {
                    highPriorityCalculator(stack, parseFloat(displayVal));
                }
                else
                    stack.push(parseFloat(displayVal));
                displayVal = calculator(stack);
            }
            else {
                var ex = $("expression").innerHTML;
                if (ex[ex.length - 1] != '!') {
                    $("expression").innerHTML += value;
                    if (displayVal == "0") {
                        displayVal = value;
                    }
                    else {
                        displayVal += value;
                    }
                }
            }
            $("result").innerHTML = displayVal;
            console.log(stack);
        };
    }
}

function factorial (x) {
    var ret = 1;
    for (var i = x; i > 0; --i) {
        ret *= i;
    }

    return ret;
}
function highPriorityCalculator(s, val) {
    s.push(val);
    for (var i = s.length / 2; i > 0; --i) {
        if (s.length < 3)
            break;
        var firstVal = s.pop();
        var op = s.pop();
        var lastVal = s.pop();
        if (op == '*') {
            s.push(firstVal * lastVal);
        }
        else if (op == '/') {
            s.push(lastVal / firstVal);
        }
        else if (op == '^') {
            s.push(Math.pow(lastVal, firstVal));
        }
        else {
            s.push(lastVal);
            s.push(op);
            s.push(firstVal);
            break;
        }
    }
}
function calculator(s) {
    var result = 0;
    var operator = "+";
    // var stackLength = s.length;
    console.log(s);
    result += s[0];
    for (var i=1; i< s.length; i++) {
        var tmp = s[i];
        if (tmp == '+')
            operator = '+';
        else if (tmp == '-')
            operator = '-';
        else if (tmp == '*')
            operator = '*';
        else if (tmp == '/')
            operator = '/';
        else if (tmp == '^')
            operator = '^';
        else {
            if (operator == '+')
                result += parseFloat(tmp);
            else if (operator == '-')
                result -= parseFloat(tmp);
            else if (operator == '*')
                result *= parseFloat(tmp);
            else if (operator == '/')
                result /= parseFloat(tmp);
            else if (operator == '^')
                result = Math.pow(tmp, result);
            console.log(result);
        }
    }
    return result;
}
