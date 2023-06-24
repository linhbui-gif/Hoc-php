import React, {useEffect, useState} from 'react'
import axios from 'axios'
const ApiDemo = () => {
  const [posts, setPosts] = useState(null)
    useEffect(() => {
      getPost()
    },[])
    const getPost = async () => {
      const {data} = await axios.get('https://jsonplaceholder.typicode.com/posts')
      setPosts(data)
    }
    return (
      <div>
        {
         posts && posts.map(element => <li>{element.title}</li>) // kieemr tra cái nào true thì trả về
        }
      </div>
    )
}
export default ApiDemo;