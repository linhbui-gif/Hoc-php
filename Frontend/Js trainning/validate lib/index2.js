function Validate(options) {

    const buttonSubmitSelector = document.querySelector('.submit_form'); // object element
    let messages = {

    };
    let messageAll = options.messages;
    const rules = options.rules;

    const validateRule = {

        required: function(fieldName, optional, elementValidate) {
            const messageKey = fieldName + "_" + elementValidate
            // 1. lay value input
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            let message;
            if(messageAll[messageKey]){
                message = messageAll[messageKey]
            } else{
                message = fieldName + 'is required'
            }
            // 2. check input chua nhap
            if(!valueInput) {
                return {
                    is_valid: false,
                    message: message
                }
            }
            return {
                is_valid: true,
                message: ''
            }
        },
        email: function(fieldName){
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valueInput)){
                return {
                    is_valid: false,
                    message: fieldName + 'is not valid email'
                }
            }
            return {
                is_valid: true,
                message: ''
            }
        },
        min: function(fieldName, minLength){
            const inputSelector = document.querySelector('#' + fieldName);
            const valueInput = inputSelector.value;
            if(valueInput.length < minLength){
                return {
                    is_valid: false,
                    message: fieldName + ' phải lớn hơn ' + minLength + ' charactor '
                }
            }
            return {
                is_valid: true,
                message: ''
            }
        },
        // max: function(fieldName, maxLength){
        //     const inputSelector = document.querySelector('#' + fieldName);
        //     const valueInput = inputSelector.value;
        //     if(valueInput.length > maxLength){
        //         return fieldName + ' phải nhỏ hơn ' + maxLength + ' charactor '
        //     }
        //     return ''
        // },
        // between: function(fieldName, between){
        //     const [min, max] = between.split(",")
        //     const inputSelector = document.querySelector('#' + fieldName);
        //     const valueInput = inputSelector.value;
        //     if(valueInput.length < min || valueInput.length < max){
        //         return fieldName + ' nằm trong khoảng ' + min + ' đến ' + max + ' charactor '
        //     }
        //     return ''
        // }
    }

    function addMessageToInputElement() {
        //input valid
        
        for(const fieldName in messages){
            const element = document.querySelector("#" + fieldName)
            const errors = messages[fieldName];
            let message;
          
            for(let i = 0; i <  errors.length; i++){
                if(!errors[i].is_valid){
                    message = errors[i].message;
                    break;
                }
            }
            if(!message){
                element.classList.add('is-valid')
                element.classList.remove('is-invalid')
                element.nextElementSibling.textContent = ""
            } else{
                element.classList.add('is-invalid')
                element.classList.remove('is-valid')
                element.nextElementSibling.classList.add('invalid-feedback');
                element.nextElementSibling.textContent = message
            }
            
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
                    const messageValidate = validateRule[elementValidate](fieldName, explodeData[1], elementValidate);
                    
                    if(!messages[fieldName]){
                        messages[fieldName] = [messageValidate];
                    } else{
                        messages[fieldName].push(messageValidate)
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
            // 'max:12',
        ],
        email: [
            'required',
            'email',
            // 'between:5,9'
        ],
        password: [
            'required'
        ]
    },
    messages: {
        name_required: 'Bắt buộc nhập tên'
    }
}

const validateInstance = new Validate(ruleValidateInput);