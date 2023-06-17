import {useState} from 'react'

const Counter = () => {
    const [counter, setCounter] = useState(0)
    const handlerCounter = () => {
        setCounter(counter + 1)
    }
    //mooxi lần chạy thì state sẽ luôn nhớ giá trị trước đó của nó.nguyên lý của closure 
    //component re render -> function gọi lại
    return (
        <>
        <h1>Counter {counter}</h1>
        <button onClick={handlerCounter}>Increment</button>
        </>
    )
}
export default Counter;
//Tên component phải viết hoa vì nó theo cơ chế class của js ==> new Counter()