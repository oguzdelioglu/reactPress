import Home from "./views/Home";
import Post from "./views/Post";
import Category from "./views/Category";
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
        path: '/category/:category_slug',
        name: 'Category',
        element: <Category></Category>
    },
    {
        path: '*',
        name: 'Not Found',
        element: <NotFound></NotFound>,
    }
];

export default router;