//Object literal

//This là object current gọi function và this nó thuộc về run time
// let course = {
//     name: "Khoa hoc",
//     tags: ['react','redux','context'],
//     getCourse:function(){
//         this.tags.forEach(function(tag){
//             console.log(this); // Ham thong thường thì this là window
//             console.log('tag', tag + this.name);
//         }.bind(this))
//     }
// }
// function coverThis(){
//     console.log(this); // lúc này this là course
// }
//coverThis.call(course)
// coverThis.apply(course,[1,2,3]) // thao túng this 

// const boundLog = coverThis.bind(course); //bind chỉ tạo ra 1 contexxt nhưng chưa thực thi function
// boundLog();

// function test(){
//     console.log(this); // this lúc này là window
// }
// console.log(window);
