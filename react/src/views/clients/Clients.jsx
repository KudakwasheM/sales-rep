import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axios-client";

const Clients = () => {
    const [clients, setClients] = useState([]);
    const [loading, setLoading] = useState(false);

    const getAllClients = () => {
        setLoading(true);

        axiosClient.get("/clients").then(({ data }) => {
            setLoading(false);
            setClients(data.data);
        });
    };

    useEffect(() => {
        getAllClients();
    }, []);

    return (
        <div>
            <div className="flex flex-row items-center justify-between mb-3">
                <h2 className="font-lg text-2xl">Clients</h2>
                <Link
                    to="/clients/create"
                    className="px-3 py-2 text-white bg-green-700"
                >
                    Add New Client
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
                                ID Number
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                D.O.B
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                EC Number
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Type
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Created By
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    {loading && (
                        <tbody>
                            <tr>
                                <td colSpan={7} className="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    )}
                    {!loading && (
                        <tbody>
                            {clients.map((client) => (
                                <tr key={client.id}>
                                    <td className="py-2">{client.name}</td>
                                    <td className="py-2">{client.id_number}</td>
                                    <td className="py-2">{client.dob}</td>
                                    <td className="py-2">{client.ec_number}</td>
                                    <td className="py-2">
                                        {client.battery_number}
                                    </td>
                                    <td className="py-2">
                                        {client.created_by}
                                    </td>
                                    <td className="text-sm py-2">
                                        <Link
                                            to={"/clients/" + client.id}
                                            className="bg-blue-300 p-1 text-white"
                                        >
                                            View
                                        </Link>
                                        &nbsp;
                                        <Link
                                            to={"/clients/" + client.id}
                                            className="bg-green-300 p-1 text-white"
                                        >
                                            Edit
                                        </Link>
                                        &nbsp;
                                        <button
                                            onClick={(ev) => onDelete(client)}
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

export default Clients;
