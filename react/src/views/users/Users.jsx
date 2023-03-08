import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const Users = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(false);
    const { setNotification } = useStateContext();

    const onDelete = async (user) => {
        if (!window.confirm("Are you sure you want to delete this user?")) {
            return;
        }

        await axiosClient.delete(`/users/${user.id}`).then(() => {
            setNotification("User deleted successfuly.");
            getAllUsers();
        });
    };

    const getAllUsers = async () => {
        setLoading(true);

        await axiosClient.get("/users").then(({ data }) => {
            setLoading(false);
            setUsers(data.data);
        });
    };

    useEffect(() => {
        getAllUsers();
    }, []);

    return (
        <div>
            <div className="flex flex-row items-center justify-between mb-3">
                <h2 className="font-lg text-2xl">Users</h2>
                <Link
                    to="/users/create"
                    className="px-3 py-2 text-white bg-green-700"
                >
                    Add New User
                </Link>
            </div>
            <div className="shadow-md p-3 bg-white">
                <table class="table-auto w-full">
                    <thead className="border border-solid border-l-0 border-r-0">
                        <tr className="bg-[#F8F8F8]">
                            <th className="py-3 text-lg font-normal text-start">
                                Name
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Email
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                EC Number
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Username
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Created At
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    {loading && (
                        <tbody>
                            <tr>
                                <td colSpan={6} className="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    )}
                    {!loading && (
                        <tbody>
                            {users.map((user) => (
                                <tr key={user.id}>
                                    <td className="py-2">{user.name}</td>
                                    <td className="py-2">{user.email}</td>
                                    <td className="py-2">{user.ec_number}</td>
                                    <td className="py-2">{user.username}</td>
                                    <td className="py-2">{user.created_at}</td>
                                    <td className="text-sm py-2">
                                        <Link
                                            to={"/users/show/" + user.id}
                                            className="bg-blue-300 p-1 text-white"
                                        >
                                            View
                                        </Link>
                                        &nbsp;
                                        <Link
                                            to={"/users/" + user.id}
                                            className="bg-green-300 p-1 text-white"
                                        >
                                            Edit
                                        </Link>
                                        &nbsp;
                                        <button
                                            onClick={(ev) => onDelete(user)}
                                            className="bg-red-500 text-white p-1"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    )}
                </table>
            </div>
        </div>
    );
};

export default Users;
