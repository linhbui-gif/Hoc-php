//Sap xep cac phần từ trong mảng theo thứ tự tăng dần bằng thuật toán buble sort

let arr = [3,7,9,2,1]
//Cach 1
// let i = 0;
// while (i < arr.length){
//     let j = 0;
//     while (j < arr.length - i) {
//         // console.table({
//         //     i: i,
//         //     j: j,
//         //     arr_j : arr[j],
//         //     arr_j_1 : arr[j + 1]
//         // })
//         if(arr[j] > arr[j + 1]){
//             let tmp = arr[j];
//             arr[j] = arr[j + 1]
//             arr[j + 1] = tmp;
//         }
//         j++;
//     }
//     i++;
// }
// console.log(arr)
//Cach 2 dung for
for (let i = 0; i < arr.length - 1; i++) {
    for(j = i + 1; j < arr.length; j++){
        if(arr[i] > arr[j]){
            let tmp = arr[j];
            arr[j] = arr[i];
            arr[i] = tmp
        }
    }
}
console.log(arr);