const App = () => {
   ToDoList(function(dataChild) {
      console.log('data', dataChild);
   })
}
const ToDoList = (callback) => {
  let childrenValue = "children value"
  callback(childrenValue)
}
App()
// cơ chế truyền cha con props là tư duy sử dụng callback để nhận gửi dữ liệu