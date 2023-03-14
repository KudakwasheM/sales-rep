import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import axiosClient from "../../axios-client";

const User = () => {
    const { id } = useParams();
    const [loading, setLoading] = useState(false);
    const [user, setUser] = useState({});

    const onDelete = async (user) => {
        if (!window.confirm("Are you sure you want to delete this user?")) {
            return;
        }

        await axiosClient.delete(`/users/${user.id}`).then(() => {
            setNotification("User deleted successfuly.");
            getAllUsers();
        });
    };

    const getUser = () => {
        setLoading(true);
        axiosClient.get(`/users/${id}`).then(({ data }) => {
            console.log(data);
            setLoading(false);
            setUser(data);
        });
    };

    if (id) {
        useEffect(() => {
            getUser();
        }, []);
    }

    return (
        <>
            <div className="bg-white p-5 shadow-md flex flex-col">
                <h2 className="text-xl font-lg text-center mb-4">
                    Showing Details For {user.name}
                </h2>
                <div>
                    {loading && (
                        <div className="my-2 text-center">Loading...</div>
                    )}
                    {!loading && (
                        <div className="flexx flex-col w-full justify-around items-center">
                            <div className="border border-1 mb-2">
                                <table className="table-fixed w-full">
                                    <tr className="">
                                        <th className="text-start py-3 pl-1">
                                            Name
                                        </th>
                                        <td>{user.name}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Email
                                        </th>
                                        <td>{user.email}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Username
                                        </th>
                                        <td>{user.username}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            EC Number
                                        </th>
                                        <td>{user.ec_number}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Phone
                                        </th>
                                        <td>{user.phone}</td>
                                    </tr>
                                    <tr>
                                        <th className="text-start py-3 pl-1">
                                            Role
                                        </th>
                                        <td>{user.role_id}</td>
                                    </tr>
                                </table>
                            </div>
                            <div className="flex flex-row">
                                <Link
                                    to={"/users/" + user.id}
                                    className="w-1/2 bg-green-500 text-white py-3 pl-1 text-center"
                                >
                                    EDIT
                                </Link>
                                <button
                                    onClick={(ev) => onDelete(user)}
                                    className="w-1/2 bg-red-500 text-white py-3 pl-1"
                                >
                                    DELETE
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
};

export default User;
