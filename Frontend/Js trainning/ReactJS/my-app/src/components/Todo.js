import { useState } from "react";
import ListItem from "./ListItem";
import FormAdd from "./FormAdd";

const ToDo = () => {
    const [data, setData] = useState([
        {
            id: 1,
            name: 'Test 1'
        },
        {
            id: 2,
            name: 'Test 2'
        },
    ])
   
    const handlerClick = (todo) => {
        setData([...data,todo])
    }
   
    const onDelete = (id) => {
        const newData = data && data.filter((element, index) => element.id !== id)
        setData(newData)
    }
    const renderList = () => {
       return data && data.map((element,index) => {
            return <ListItem data={element} index={index} onDelete={onDelete}/>
        })
    }
    return (
        <>
        <FormAdd handlerClick={handlerClick} />
        <ul id="myUL">
            {renderList()}
        </ul>
        </>
    )
}
export default ToDo;