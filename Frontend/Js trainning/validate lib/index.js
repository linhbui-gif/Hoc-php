function Validate(options) {

    const buttonSubmitSelector = document.querySelector('.submit_form'); // object element
    let messages = {

    };
    const rules = options.rules;

    const validateRule = {

        required: function(fieldName) {
            // 1. lay value input
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;

            // 2. check input chua nhap
            if(!valueInput) {
                return fieldName + ' is required';
            }
        },
        email: function(fieldName){
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valueInput)){
                  return fieldName + 'is not valid email'
            }
            return null;
        },
        min: function(fieldName, minLength){
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            if(valueInput.length < minLength){
                return fieldName + ' phải lớn hơn ' + minLength + ' charactor '
            }
            return ''
        },
        max: function(fieldName, maxLength){
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            if(valueInput.length > maxLength){
                return fieldName + ' phải nhỏ hơn ' + maxLength + ' charactor '
            }
            return ''
        },
        between: function(fieldName, between){
            const [min, max] = between.split(",")
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            if(valueInput.length < min || valueInput.length < max){
                return fieldName + ' nằm trong khoảng ' + min + ' đến ' + max + ' charactor '
            }
            return ''
        }
    }

    function addMessageToInputElement() {
        for (const fieldName in messages) {
            // 1. timinput selector
            const inputSelector = document.querySelector('#' + fieldName);
            const spanError = inputSelector.nextElementSibling;

            // add text and show error
            inputSelector.classList.add('is-invalid');
            spanError.textContent = messages[fieldName][0];
            spanError.classList.add('invalid-feedback');
        }
        //check no error
        if(Object.keys(messages).length === 0){
            const inputAll = document.querySelectorAll('.form-control')
            inputAll.forEach(element => {
                element.classList.add('is-valid')
                element.classList.remove('is-invalid')
                element.nextElementSibling.textContent = ""
            })
        } else if(Object.keys(rules).length > Object.keys(messages).length){
            const diffirenceItem = Object.keys(rules).filter(item => Object.keys(messages).indexOf(item) === -1)
            diffirenceItem.forEach(element => {
                const inputRemove = document.querySelector("#" + element)
                inputRemove.classList.add('is-valid')
                inputRemove.classList.remove('is-invalid')
                inputRemove.nextElementSibling.textContent = ""
            })
        }
        messages = {}
    }

    function handleSubmitForm() {
        // validate form
        // 1. loop qua cac phan tu validate
        for (const fieldName in rules) {
           const validateHandleArray = rules[fieldName];
           // loop validate array
            validateHandleArray.forEach(
                function(elementValidate) {
                    // chạy hàm validate
                    const explodeData = elementValidate.split(":");
                    elementValidate = explodeData[0]
                    const messageValidate = validateRule[elementValidate](fieldName, explodeData[1]);
                    if(messageValidate){
                        if(messages[fieldName]){
                            messages[fieldName].push(messageValidate)
                        } else {
                            messages[fieldName] = [messageValidate];
                        }
                    }
                }
            )
        }

        // add message to input element
        addMessageToInputElement();
    }

    function initEvent() {
        // them su kien cho button submit
        buttonSubmitSelector.addEventListener("click", handleSubmitForm);
    }

    // init su kien
    initEvent();

}

// input
let ruleValidateInput = {
    rules: {
        name: [
            'required',
            'min:4',
            'max:12',
        ],
        email: [
            'required',
            'email',
            // 'between:5,9'
        ],
        password: [
            'required'
        ]
    }
}

const validateInstance = new Validate(ruleValidateInput);