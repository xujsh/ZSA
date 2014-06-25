//
//  ProfileViewController.m
//  teaching
//
//  Created by merlin on 14-1-16.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "ProfileViewController.h"

@interface ProfileViewController ()

@end

@implementation ProfileViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    NSLog(@"profile view did load");
    [super viewDidLoad];
    [self initWebView];
    [self showUserCenter];
}

- (void)viewWillAppear:(BOOL)animated
{
    //NSLog(@"user center will appear");
    if(self.isShowedLoginView)
    {
        self.isShowedLoginView = NO;
        [self showUserCenter];
    }
}

- (void)showUserCenter
{
    NSLog(@"showUserCenter a");
    [self loadUser];

    if([self isGuest])
    {
        //NSString *profileUrl = URLMAKER(URL_PROFILE, [self getUserSid]);
        //NSLog(@"url %@", profileUrl);
        [self setNavTitle:@"登录-用户中心"];
        [self showLoginView];

    }
    else
    {
        [self setNavTitle:@"用户中心"];

        //需要个人设置页地址
        //NSString * profileUrl = [NSString stringWithFormat:@"http://coursement.test.icesmart.cn/index.php/个人设置页地址路径?sid=%@",[self.member valueForKey:@"sid"]];

        NSString *profileUrl = URLMAKER(URL_PROFILE, [self getUserSid]);
        NSLog(@"user center url %@", profileUrl);
        NSURLRequest *request =[NSURLRequest requestWithURL:[NSURL URLWithString:profileUrl]];
        [self.webView loadRequest:request];
    }

    [self addMenuButton];
    NSLog(@"showUserCenter b");
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    [super webView:webView shouldStartLoadWithRequest:request navigationType:navigationType];
    if (navigationType == UIWebViewNavigationTypeLinkClicked)
    {
        NSURL *URL = [request URL];
        NSLog(@"profile view c NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);
        NSLog(@"profile view request request url :%@",[URL standardizedURL]);
        NSString *reqURL = [NSString stringWithFormat:@"%@", [URL standardizedURL]];

        NSString *equalStr = [NSString stringWithFormat:@"%@%@", API_URL_PREFIX, URL_NEEDLOGIN];
        if ([[URL scheme] isEqualToString:@"http"])
        {
            //CourseInfoViewController *ctl = [[CourseInfoViewController alloc]initWithUrl:[request URL] ];
            //[self.navigationController pushViewController:ctl animated:YES];
            //[ctl release];
            //NSLog(@"reqURL: %@", reqURL);
            NSRange reqURLRange = [reqURL rangeOfString:API_URL_LOGOUT];
            if(reqURLRange.location == NSNotFound)
            {
                CommonViewController *ctl = [[CommonViewController alloc] initWithUrl:[request URL]];
                [self.navigationController pushViewController:ctl animated:YES];
                [ctl release];
            }
            else
            {
                return YES;
            }

        }else{

            //Not a URL

        }

        return NO;
        
    }
    
    return YES;
}

- (void) showLoginView
{
    [super showLoginView];
    LoginViewController *loginview = [[LoginViewController alloc]init];
    [self.navigationController pushViewController:loginview animated:YES];
    [loginview release];
}

- (void)didLoginSuccess
{
    //[self showUserCenter];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    
}

@end
