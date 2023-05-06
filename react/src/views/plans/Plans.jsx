import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../../axios-client";
import { useStateContext } from "../../contexts/ContextProvider";

const Plans = () => {
    const [plans, setPlans] = useState([]);
    const [loading, setLoading] = useState(false);
    const { setNotification } = useStateContext();

    const onDelete = async (plans) => {
        if (!window.confirm("Are you sure you want to delete this plan?")) {
            return;
        }

        await axiosClient.delete(`/plans/${plan.id}`).then(() => {
            setNotification("Plan deleted successfuly.");
            getPlans();
        });
    };

    const getPlans = async () => {
        setLoading(true);

        await axiosClient.get("/plans").then(({ data }) => {
            setLoading(false);
            setPlans(data.data);
        });
    };

    useEffect(() => {
        getPlans();
    }, []);
    return (
        <>
            <div className="flex flex-row items-center justify-between mb-3">
                <h2 className="font-lg text-2xl">Plans</h2>
                <Link
                    to="/plans/create"
                    className="px-3 py-2 text-white bg-green-700"
                >
                    Add New Plan
                </Link>
            </div>
            <div className="shadow-md p-3 bg-white">
                <table className="table-auto w-full">
                    <thead className="border border-solid border-l-0 border-r-0">
                        <tr className="bg-[#F8F8F8]">
                            <th className="py-3 text-lg font-normal text-start">
                                Amount
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Battery Type
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Installments
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Paid Installments
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Deposit
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Balance
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Client
                            </th>
                            <th className="py-3 text-lg font-normal text-start">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    {loading && (
                        <tbody>
                            <tr>
                                <td colSpan={8} className="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    )}
                    {!loading && (
                        <tbody>
                            {plans.length > 0 ? (
                                plans.map((plan) => (
                                    <tr key={plan.id}>
                                        <td className="py-2">{plan.amount}</td>
                                        <td className="py-2">
                                            {plan.battery_type == "d_100_usd" &&
                                                "D 100 USD"}
                                            {plan.battery_type ==
                                                "d_100_rtgs" && "D 100 RTGS"}
                                        </td>
                                        <td className="py-2">
                                            {plan.installments}
                                        </td>
                                        <td className="py-2">
                                            {plan.paid_installments}
                                        </td>

                                        <td className="py-2">{plan.deposit}</td>
                                        <td className="py-2">{plan.balance}</td>
                                        <td className="py-2">
                                            {plan.client.name}
                                        </td>
                                        <td className="text-sm py-2">
                                            <Link
                                                to={"/plans/show/" + plan.id}
                                                className="bg-blue-300 p-1 text-white"
                                            >
                                                View
                                            </Link>
                                            &nbsp;
                                            <Link
                                                to={"/plans/" + plan.id}
                                                className="bg-green-300 p-1 text-white"
                                            >
                                                Edit
                                            </Link>
                                            &nbsp;
                                            <button
                                                onClick={(ev) => onDelete(plan)}
                                                className="bg-red-500 text-white p-1"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td
                                        colSpan={8}
                                        className="text-center text-red-600"
                                    >
                                        No Plans Found
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    )}
                </table>
            </div>
        </>
    );
};

export default Plans;
