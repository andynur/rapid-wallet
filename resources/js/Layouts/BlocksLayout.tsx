import {
    CircleUser,
    Menu,
    Package2
} from "lucide-react"

import { Button } from "@/shadcn/ui/button"
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/shadcn/ui/dropdown-menu"
import { Sheet, SheetContent, SheetTrigger } from "@/shadcn/ui/sheet"
import type { User } from "@/types"
import { Link } from "@inertiajs/react"
import type { PropsWithChildren } from "react"

export default function BlocksLayout({ user, children }: PropsWithChildren<{ user: User }>) {
    return (
        <div className="flex min-h-screen w-full flex-col">
            <header className="sticky top-0 flex h-16 items-center gap-4 border-b bg-background px-4 md:px-10">
                <nav className="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6">
                    <Link
                        href={route('dashboard')}
                        className="flex items-center gap-2 text-lg font-semibold md:text-base"
                    >
                        <Package2 className="h-6 w-6" />
                        <span className="sr-only">Rapid Wallet</span>
                    </Link>
                    <Link
                        href={route('dashboard')}
                        className="text-foreground transition-colors hover:text-foreground"
                    >
                        Dashboard
                    </Link>
                    <Link
                        href={route('deposit')}
                        className="text-muted-foreground transition-colors hover:text-foreground"
                    >
                        Deposit
                    </Link>
                    <Link
                        href={route('withdraw')}
                        className="text-muted-foreground transition-colors hover:text-foreground"
                    >
                        Withdraw
                    </Link>
                </nav>
                <Sheet>
                    <SheetTrigger asChild>
                        <Button
                            variant="outline"
                            size="icon"
                            className="shrink-0 md:hidden"
                        >
                            <Menu className="h-5 w-5" />
                            <span className="sr-only">Toggle navigation menu</span>
                        </Button>
                    </SheetTrigger>
                    <SheetContent side="left">
                        <nav className="grid gap-6 text-lg font-medium">
                            <Link
                                href={route('dashboard')}
                                className="flex items-center gap-2 text-lg font-semibold"
                            >
                                <Package2 className="h-6 w-6" />
                                <span className="sr-only">Rapid Wallet</span>
                            </Link>
                            <Link href={route('dashboard')} className="hover:text-foreground">
                                Dashboard
                            </Link>
                            <Link
                                href={route('dashboard')}
                                className="text-muted-foreground hover:text-foreground"
                            >
                                Deposit
                            </Link>
                            <Link
                                href={route('dashboard')}
                                className="text-muted-foreground hover:text-foreground"
                            >
                                Withdraw
                            </Link>
                        </nav>
                    </SheetContent>
                </Sheet>
                <div className="flex w-full items-center gap-4 md:ml-auto md:gap-2 lg:gap-4">
                    <div className="ml-auto flex-1 sm:flex-initial">

                    </div>
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost">
                                <div className="flex gap-3">
                                    <CircleUser className="h-5 w-5" />
                                    <span>{user.name}</span>
                                </div>
                                <span className="sr-only">Toggle user menu</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuLabel>
                                <Link href={route('profile.edit')}>
                                    Profile
                                </Link>
                            </DropdownMenuLabel>
                            <DropdownMenuSeparator />
                            <DropdownMenuItem>
                                <Link href={route('logout')} method="post" as="button">
                                    Logout
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </header>
            <main className="flex flex-1 flex-col gap-4 p-4 md:px-10 md:gap-8 md:p-8">
                {children}
            </main>
        </div>
    )
}
