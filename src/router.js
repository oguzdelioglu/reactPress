import Home from "./views/Home";
import Post from "./views/Post";
import NotFound from "./views/NotFound";

const router = [
    {
        path: '/',
        name: 'Home',
        element: <Home></Home>
    },
    {
        path: '/post/:post_url',
        name: 'Post',
        element: <Post></Post>
    },
    {
        path: '*',
        name: 'Not Found',
        element: <NotFound></NotFound>,
    }
];

export default router;