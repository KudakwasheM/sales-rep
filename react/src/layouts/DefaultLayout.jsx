import React from "react";
import { useEffect } from "react";
import { Link, Navigate, Outlet } from "react-router-dom";
import axiosClient from "../axios-client";
import { useStateContext } from "../contexts/ContextProvider";

const DefaultLayout = () => {
    const { user, token, notification, setUser, setToken } = useStateContext();

    if (!token) {
        return <Navigate to="/login" />;
    }

    const onLogout = (ev) => {
        ev.preventDefault();

        axiosClient.post("/logout").then(() => {
            setUser({});
            setToken(null);
        });
    };

    useEffect(() => {
        axiosClient.get("/user").then(({ data }) => {
            setUser(data);
        });
    }, []);
    return (
        <div className="relative flex min-h-screen bg-gray-100">
            <aside className="bg-orange-400 shadow max-h-screen sticky top-0 text-white w-64 px-6">
                <Link to="/dashboard">
                    <h1 className="text-4xl px-2 py-4">Sales</h1>
                </Link>
                <nav className="py-5">
                    <Link
                        to="/dashboard"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Dashboard
                    </Link>
                    <Link
                        to="/clients"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Clients
                    </Link>
                    <Link
                        to="/plans"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Plans
                    </Link>
                    <Link
                        to="/payments"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Payments
                    </Link>
                    <Link
                        to="/tokens"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Tokens
                    </Link>
                    <Link
                        to="/users"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Users
                    </Link>
                    <Link
                        to="/payments"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Reports
                    </Link>
                    <Link
                        to="/payments"
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Settings
                    </Link>
                    <Link
                        to=""
                        onClick={onLogout}
                        className="flex items-center py-3 px-4 hover:bg-white hover:text-orange-400"
                    >
                        Logout
                    </Link>
                </nav>
            </aside>

            <div className="flex-1">
                <header className="bg-white flex sticky top-0 shadow-sm px-2 py-4 justify-end z-10 border-b-2 border-orange-200">
                    <div className="mr-8">{user.name}</div>
                </header>
                {/* <main>
                    <Outlet />
                    <footer className="flex bottom-0 shadow-sm text-center items-center justify-center px-2 py-4 z-10">
                        <div className="text-black italic">
                            Sales Rep &nbsp; 2023. All Right Reserved.
                        </div>
                    </footer>
                </main> */}
                <main className="p-8">
                    <Outlet />
                </main>
            </div>
            {notification && (
                <div className="bg-green-500 text-white fixed right-4 bottom-4 z-50 py-5 px-3">
                    {notification}
                </div>
            )}
        </div>
    );
};

export default DefaultLayout;
