import { useState } from "react";

const FormAdd = ({handlerClick}) => {
  const [todo, setTodo] = useState({})
  const handlerChange = (e) => {
    const value = e.target.value;
    const name = e.target.name;
    setTodo({
        ...todo,
        [name] : value
    })
   }
   const onClick = () => {
    handlerClick(todo)
   }
    return (
      <>
      <div id="myDIV" className="header">
            <h2 >My To Do List</h2>
            <input onChange={handlerChange} name="todo" type="text" id="myInput" placeholder="Title..." />
            <span onClick={onClick} className="addBtn">Add</span>
        </div>
      </>
    )
  }
  export default FormAdd;