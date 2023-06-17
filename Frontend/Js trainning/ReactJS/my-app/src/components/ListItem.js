import { useState } from "react";

const ListItem = ({data, onDelete}) => {
  const [checked, setChecked] = useState(false)
  const handlerChecker = () => {
    setChecked(!checked)
  }
  return <li onClick={handlerChecker} className={`${checked ? 'checked' : ''}`} key={data.id}>{data?.name} <span onClick={() => onDelete(data.id)} >X</span> </li>
}
export default ListItem;