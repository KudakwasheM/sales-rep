import { createBrowserRouter, Navigate } from "react-router-dom";
import DefaultLayout from "./layouts/DefaultLayout";
import GuestLayout from "./layouts/GuestLayout";
import Login from "./views/auth/Login";
import Dashboard from "./views/dashboard/Dashboard";
import NotFound from "./views/NotFound";
import Clients from "./views/clients/Clients";
// import UserForm from "./views/UserForm";
import Users from "./views/users/Users";

const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout />,
        children: [
            { path: "/", element: <Navigate to="/dashboard" /> },
            { path: "/dashboard", element: <Dashboard /> },
            { path: "/clients", element: <Clients /> },
            { path: "/users", element: <Users /> },
            // { path: "/users/create", element: <UserForm key="userCreate" /> },
            // { path: "/users/:id", element: <UserForm key="userUpdate" /> },
        ],
    },
    {
        path: "/",
        element: <GuestLayout />,
        children: [
            { path: "/login", element: <Login /> },
            // { path: "/signup", element: <Signup /> },
        ],
    },
    { path: "*", element: <NotFound /> },
]);

export default router;
