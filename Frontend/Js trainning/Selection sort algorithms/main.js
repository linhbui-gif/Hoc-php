// Selection sort
let arr = [3,5,2,6,8];
//Sap sep theo value ==> Cach 1
for (let i = 0; i < arr.length - 1; i++) {
    for (let j = i + 1; j < arr.length; j++) {
        if(arr[i] > arr[j]){
            let tmp = arr[j];
            arr[j] = arr[i];
            arr[i] = tmp;
        }
    }
}

//Sap sep theo index ==> Cach 2
// for (let i = 0; i < arr.length - 1; i++) {
//     let indexMin = i;
//     for (let j = i + 1; j < arr.length; j++) {
//        if(arr[indexMin] > arr[j]){
//         indexMin = j
//        }
//     }
//     if(i !== indexMin){
//         let tmp = arr[i];
//         arr[i] = arr[indexMin];
//         arr[indexMin] = tmp;
//     }
// }

