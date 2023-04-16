// The find() method returns the value of the first element that passes a test.

// The find() method executes a function for each array element.

// The find() method returns undefined if no elements are found.

// The find() method does not execute the function for empty elements.

// The find() method does not change the original array.
//Function declare  and function expression

//prototype refer đến thằng cha ==> thêm method vào core.

/**
 * Các hàm luôn luôn nhận vào argument là 1 function do người dùng định nghĩa
 * Function argument luôn luôn được thực thi với mỗi element trong hàm
 * Function thực thi luôn luôn nhận vào element array và trả về kết quả nào đó.
 * Dựa vào kết quả trả về của function thực thi thì function core sẽ trả về kết quả tương ứng
 */
const ages = [23, 23, 35, 3];

Array.prototype.findCustom = function(callback){
   if(Array.isArray(this) && this.length){
    for(let element of this){
        const isCallbackTrue = callback(element);
        if(isCallbackTrue){
          return element;
        }
     }
   }
   return undefined;
}
Array.prototype.filterCustom = function(callback){
  const newArr = [];
  if(Array.isArray(this) && this.length){
    for(element of this){
        const result = callback(element)
        if(result){
            newArr.push(element)
        }
    }
  }
  return newArr;
}
Array.prototype.findIndexCustom  = function(callback){
    if(Array.isArray(this) && this.length){
        for (let index = 0; index < this.length; index++) {
            const isCallbackTrue = callback(this[index]);
            if(isCallbackTrue){
                return index;
            }
        }
       }
       return -1;
}
Array.prototype.someCustom = function(callback){
    if(Array.isArray(this) && this.length){
        for(let element of this){
            const isCallbackTrue = callback(element);
            if(isCallbackTrue){
              return true;
            }
         }
       }
       return false;
}

//Neu cos 1 item ko thoa mãn điều kiện thì sẽ return false còn lại phải thỏa mãn hết thfi return true
Array.prototype.everyCustom = function(callback){
    if(Array.isArray(this) && this.length){
        for(let element of this){
            const isCallbackFalse = callback(element);
            //Handler false in for
            if(!isCallbackFalse){
              return false;
            }
         }
       }
       return true;
}
Array.prototype.mapCustom = function(callback){
  const newArr = [];
  if(Array.isArray(this) && this.length){
    for(let element of this){
        const result = callback(element);
        newArr.push(result)
     }
   }
   return newArr;
}
const checkAges = function(element){ 
    if(element < 40){
        return true;
    }
    return false;
}
// const result = ages.findCustom(
//     //argument
//     checkAges
// )
// const result = ages.filterCustom(
//     //argument
//     checkAges
// )
const changeAge = function(element){
  return element * 2;
}
// const result = ages.everyCustom(checkAges)
// const result = ages.mapCustom(changeAge)
// console.log(result);
// const users = [
//   {
//     name: 'duc',
//     email: 'linhbq68@wru.vn'
//   },
//   {
//     name: 'duc12',
//     email: 'linhbq6856@wru.vn'
//   },
//   {
//     name: 'duc123',
//     email: 'linhbq685@wru.vn'
//   },
// ]
//ouput expect
// [
//   {
//     'linhbq68@wru.vn': {name: 'duc',email: 'linhbq68@wru.vn'},
//   },
//   {
//     'linhbq6856@wru.vn': {name: 'duc12',email: 'linhbq6856@wru.vn'},
//   },
//   {
//     'linhbq685@wru.vn': {name: 'duc123',email: 'linhbq685@wru.vn'},
//   }
// ]
// const result = users.mapCustom(function(element) {
//   // const object = {};
//   const keyName = element.email;
//   // object[keyName] = element; Cach  1
//   return {[keyName]: element}; //cach 2 nội suy dynamic key object
// })
// console.log(result);

const array1 = [1, 2, 3, 4];
// 0 + 1 + 2 + 3 + 4
const initialValue = 0;
/**
 * Có giá trị khởi tạo 
 * Luowjt chajy thu nhất accumulator = initalValue
 * Lượt chạy thứ 1 : accumulator = 0, currentValue = 1 => return 0 + 1;
 * Lượt chạy thứ 2 : accumulator = 1, currentValue = 2 => return 1 + 2;
 * Lượt chạy thứ 3 : accumulator = 3, currentValue = 3 => return 3 + 3;
 * Lượt chạy thứ 4 : accumulator = 6, currentValue = 4 => return 6 + 4;
 * Không có giá trị khởi tạo 
 * Lượt chạy thứ 1 : accumulator = array[0], currentValue = array[1] => return 1 + 2;
 * Lượt chạy thứ 2 : accumulator = 3,  currentValue = array[2] => return 3 + 3;
 * Lượt chạy thứ 3 : accumulator = 6,  currentValue = array[3] => return 6 + 4;
 */
Array.prototype.reduceCustom = function(callback,initalValue){
  let i = 0;
  let accumulator;
  if(initalValue === undefined){
    accumulator = this[0];
    i++;
  } else {
    accumulator = initalValue;
  }
  while(i < this.length){
    accumulator = callback(accumulator,this[i], i)
    i++;
  }
  return accumulator;
}
const sumWithInitial = array1.reduceCustom(
  function(accumulator, currentValue, index) {
    // console.table({
    //   "luot chay thu": index + 1,
    //   currentValue: currentValue,
    //   accumulator: accumulator
    // })
    return accumulator + currentValue;
  },
  initialValue
);

// console.log(sumWithInitial);
let arrNumber = [1,2,3,4,1,1]
// function countNumberOccurrences(arr, number){
//    let count = 0;
//    if(arr.length){
//     for (let i of arr) {
//       if(i === number){
//         count++;
//       }
//     }
//    }
//    return count;
// }
function countNumberOccurrences(arr, number){
  const result = arr.reduceCustom(
    function(acc,curr){ 
         let occurrences;
         if(curr === number){
          occurrences = 1;
         } else {
          occurrences = 0
         }
         return acc + occurrences;
    },
    0
  )
  return result;
}
function maxElementArray(arr){
  const result = arr.reduceCustom(
    function(acc,curr){
        if(acc > curr){
          return acc;
        } else {
          return curr;
        }
    }
   )
  return result;
}
// console.log(countNumberOccurrences(arrNumber, 1));
console.log(maxElementArray(arrNumber));