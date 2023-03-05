import { createBrowserRouter, Navigate } from "react-router-dom";
import DefaultLayout from "./layouts/DefaultLayout";
import GuestLayout from "./layouts/GuestLayout";
import Login from "./views/auth/Login";
import Dashboard from "./views/dashboard/Dashboard";
import NotFound from "./views/NotFound";
import Clients from "./views/clients/Clients";
import Users from "./views/users/Users";
import UserForm from "./views/users/UserForm";
import ClientForm from "./views/clients/ClientForm";
import Payments from "./views/payments/Payments";
import Plan from "./views/plans/Plan";
import Reports from "./views/reports/Reports";
import Tokens from "./views/tokens/Tokens";
import User from "./views/users/User";
import Client from "./views/clients/Client";

const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout />,
        children: [
            { path: "/", element: <Navigate to="/dashboard" /> },
            { path: "/dashboard", element: <Dashboard /> },
            { path: "/clients", element: <Clients /> },
            { path: "/payments", element: <Payments /> },
            { path: "/plans", element: <Plan /> },
            { path: "/reports", element: <Reports /> },
            { path: "/tokens", element: <Tokens /> },
            { path: "/users", element: <Users /> },
            { path: "/users/create", element: <UserForm key="userCreate" /> },
            { path: "/users/:id", element: <UserForm key="userUpdate" /> },
            { path: "/users/show/:id", element: <User /> },
            {
                path: "/clients/create",
                element: <ClientForm key="clientCreate" />,
            },
            {
                path: "/clients/:id",
                element: <ClientForm key="clientUpdate" />,
            },
            { path: "/clients/show/:id", element: <Client /> },
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
