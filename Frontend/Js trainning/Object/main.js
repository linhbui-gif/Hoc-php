/**
 * Khi dùng indexOf hoặc includes thì chỉ có tác dụng với giá trị nguyên thủy
 *
 */
const status = {
    '1': 'pending',
    '2': 'complete',
}
// const newArr =  [
//     {
//        label: 'pending',
//        value: '1'
//     },
//     {
//        label: 'complete',
//        value: '2'
//     }
// ]
const arr = [];
const obj = {}
for (const [key, value] of Object.entries(status)) {
    obj['label'] = value;
    obj['value'] = key;
    arr.push({...obj})
}
// console.log(arr)
const course = [
    {id: 1, name : 'js', price:200},
    {id: 2, name : 'React', price:500},
    {id: 3, name : 'PHP', price:600},
    {id: 4, name : 'Nodejs', price:100},
]
//1 Biến đổi mảng name => js course
// 2 Thực hiện lọc với phần tử mảng có price >= 200
// 3 Xóa phần tử trong mảng có id= 1
// 4 tính tổng giá các khóa học
const newCouse = course && course.map(element => {
    return Object.assign(element, {name: element.name + ' ' +  'course'});
})
const coursePrice = course && course.filter(element => element.price >= 200);
const courseDeleteId = course.filter(element => element.id !== 4)

const total = course.reduce(function (acc,curr){
    return acc + curr.price;
},0)
// console.log(total)

//Su dung group by
const cars = [
    {
        'make': 'audi',
        'model': 'r8',
        'year': '2012'
    },
    {
        'make': 'audi',
        'model': 'rs5',
        'year': '2013'
    },
    {
        'make': 'ford',
        'model': 'mustang',
        'year': '2012'
    },
];
//Cach 1
// const results = {}
// cars.forEach(item => {
//     const keyGroup = item.make;
//     if(!results[keyGroup]){
//         results[keyGroup] = []
//     }
//     results[keyGroup].push(item);
// })
//Cach 2
// const reslt = cars.reduce(function (acc, curr){
//     const keyGroup = curr.make;
//     if(!acc[keyGroup]){
//         acc[keyGroup] = [{model: curr.model, year: curr.year}];
//     } else {
//         acc[keyGroup].push({model: curr.model, year: curr.year})
//     }
//     return acc;
// }, {})
// console.log(reslt)
//Output expect
// const cars = {
//     'audi': [
//         {
//             'model': 'r8',
//             'year': '2012'
//         }, {
//             'model': 'rs5',
//             'year': '2013'
//         },
//     ],

//     'ford': [
//         {
//             'model': 'mustang',
//             'year': '2012'
//         }, {
//             'model': 'fusion',
//             'year': '2015'
//         }
//     ],

//     'kia': [
//         {
//             'model': 'optima',
//             'year': '2012'
//         }
//     ]
// }

const courseArr = [
    {id: 1, name : 'js', price:200}
]
const courseArr2 = [
    {id: 1, name : 'js', price:200}
]
//Check name và value bằng nhau return true
function equal(course1, course2){
    let flag = true;
    course1.forEach((c1, index) => {
        if(c1.price === course2[index]['price'] && c1.name === course2[index]['name']){
            flag = false;
        }
    })
    return flag;
}

console.log(equal(courseArr,courseArr2))
//check  memory cùng vị trí trên bộ nhớ thì true còn khác thì false
function isSame(course1, course2){
   if(course1 !== course2){
       return false;
   }
   return true;
}

console.log(isSame(courseArr,courseArr2))