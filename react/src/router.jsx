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
import PlanForm from "./views/plans/PlanForm";
import Plans from "./views/plans/Plans";
import Reports from "./views/reports/Reports";
import Tokens from "./views/tokens/Tokens";
import User from "./views/users/User";
import Client from "./views/clients/Client";
import PaymentForm from "./views/payments/PaymentForm";
import Payment from "./views/payments/Payment";
import TokenForm from "./views/tokens/TokenForm";
import Token from "./views/tokens/Token";

const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout />,
        children: [
            { path: "/", element: <Navigate to="/dashboard" /> },
            { path: "/dashboard", element: <Dashboard /> },

            // Client Routes
            { path: "/clients", element: <Clients /> },
            {
                path: "/clients/create",
                element: <ClientForm key="clientCreate" />,
            },
            {
                path: "/clients/:id",
                element: <ClientForm key="clientUpdate" />,
            },
            { path: "/clients/show/:id", element: <Client /> },

            //Payment Routes
            { path: "/payments", element: <Payments /> },
            {
                path: "/payments/create",
                element: <PaymentForm key="paymentCreate" />,
            },
            {
                path: "/payments/:id",
                element: <PaymentForm key="paymentUpdate" />,
            },
            { path: "/payments/show/:id", element: <Payment /> },

            //Plan Routes
            { path: "/plans", element: <Plans /> },
            {
                path: "/plans/create",
                element: <PlanForm key="planCreate" />,
            },
            {
                path: "/clients/:id",
                element: <PlanForm key="planUpdate" />,
            },
            { path: "/plans/show/:id", element: <Plan /> },

            //Reports Routes
            { path: "/reports", element: <Reports /> },

            //Token Routes
            { path: "/tokens", element: <Tokens /> },
            {
                path: "/tokens/create",
                element: <TokenForm key="tokenCreate" />,
            },
            { path: "/tokens/:id", element: <TokenForm key="tokenUpdate" /> },
            { path: "/tokens/show/:id", element: <Token /> },

            //User Routes
            { path: "/users", element: <Users /> },
            { path: "/users/create", element: <UserForm key="userCreate" /> },
            { path: "/users/:id", element: <UserForm key="userUpdate" /> },
            { path: "/users/show/:id", element: <User /> },
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
