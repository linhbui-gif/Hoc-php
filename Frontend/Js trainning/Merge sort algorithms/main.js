let arrSort = [4,3,5,6,2,1,7]

function mergeSort(arr){
    if(arr.length ===  1){
        return arr;
    }
   // Chia đôi mảng
   let middle = Math.floor(arr.length / 2);
   let left = arr.slice(0, middle);
   let right = arr.slice(middle);
   left = mergeSort(left);
   right = mergeSort(right);
   return merge(left,right)
}
function merge(left,right){
   let sortedArr = [];
   //Lấy ra các phần tử từ 2 mảng đẩy vào 1 mảng mới
    while(left.length > 0 && right.length > 0){
        if(left[0] > right[0]){
            sortedArr.push(right[0])
            right.splice(0, 1);
        } else {
            sortedArr.push(left[0])
            left.splice(0, 1);
        }
    }
    //Lấy phần tử của mảng còn lại đẩy vào mảng chung
    while(right.length > 0){
        sortedArr.push(right[0])
        right.splice(0, 1);
    }
    while(left.length > 0){
        sortedArr.push(left[0])
        left.splice(0, 1);
    }
    return sortedArr;
}
const arrEnd = mergeSort(arrSort)
console.log(arrEnd);