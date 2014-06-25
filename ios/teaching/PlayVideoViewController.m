//
//  PlayVideoViewController.m
//  teaching
//
//  Created by merlin on 13-12-24.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "PlayVideoViewController.h"

@interface PlayVideoViewController ()

@end

@implementation PlayVideoViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}
- (id) initWithUrl:(NSURL *)url
{
    if( (self=[self init])) {
        
        self.playurl = url;
        
    }
    return self;
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	[self setNavTitle:@"课程学习"];
    
    [self addBackButton];
    
    [self initWebView];


    [[UIDevice currentDevice] beginGeneratingDeviceOrientationNotifications];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(deviceOrientationDidChange:)name:UIDeviceOrientationDidChangeNotification object:nil];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(playerWillEnterFullscreen:) name:MPMoviePlayerWillEnterFullscreenNotification object:nil];
    [self showViewController];
    NSLog(@"play video vc view did load");
}

-(void)deviceOrientationDidChange:(NSObject*)sender
{
    UIDevice* device = [sender valueForKey:@"object"];
    if(device.orientation == 3 || device.orientation == 4)
    {
        NSLog(@"%d",device.orientation);
        //[[UIApplication sharedApplication] setStatusBarOrientation:UIInterfaceOrientationLandscapeRight animated:NO];
        //self.webView.allowsInlineMediaPlayback = NO;
//        element.webkitRequestFullScreen;
        [self runWebfunctionByName:@"videoToFullscreen"];
        //self.webView.allowsInlineMediaPlayback = NO;
    }
}

- (void)showViewController
{
    NSLog(@"%@", self.playurl);
    UIView *titleBtnView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 200, 22)];

    UIButton *infoBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    [infoBtn setBackgroundImage:[UIImage imageNamed:@"infoBtn.png"] forState:UIControlStateNormal];
    [infoBtn setFrame:CGRectMake(90, 0, 22, 22)];
    [infoBtn addTarget:self action:@selector(didInfoBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
    [titleBtnView addSubview:infoBtn];

    UIButton *lastLessonBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    [lastLessonBtn setBackgroundImage:[UIImage imageNamed:@"lastLessonBtn.png"] forState:UIControlStateNormal];
    [lastLessonBtn setFrame:CGRectMake(20, 5, 19, 11)];
    [lastLessonBtn addTarget:self action:@selector(didLastLessonBtnClicked:) forControlEvents:UIControlEventTouchUpInside];


    [titleBtnView addSubview:lastLessonBtn];

    [self setNavTitleView:titleBtnView];
    
    NSURLRequest *request =[NSURLRequest requestWithURL:self.playurl];
    self.webView.allowsInlineMediaPlayback = YES;
    self.webView.mediaPlaybackRequiresUserAction = NO;
    [self.webView loadRequest:request];
}

- (void)didInfoBtnClicked:(id)sender
{
    NSLog(@"open");
    [self loadUser];
    NSString *lessonID = [self runWebfunctionByName:@"getLessonid"];
    NSLog(@"lessonID: %@", lessonID);
    NSString *reqStr = [NSString stringWithFormat:@"%@%@", URL_VIDEO_INFO, lessonID];
    NSURL *URL = [NSURL URLWithString:URLMAKERS(reqStr, [self getUserSid])];
    CommonViewController *classInfo = [[CommonViewController alloc] initWithUrl:URL];
    [self.navigationController pushViewController:classInfo animated:YES];
    [classInfo release];
}

- (void)didLastLessonBtnClicked:(id)sender
{
    [self runWebfunctionByName:@"intoLastLesson"];
}

- (void)goBack:(id)sender
{
    [super goBack:sender];
    [self.webView loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:@"about:blank"]]];
}

- (BOOL) shouldAutorotate
{
    NSLog(@"shouldAutorotate");
    return NO;
}

- (NSUInteger)supportedInterfaceOrientations
{
    return UIInterfaceOrientationMaskPortrait;
}
- (UIInterfaceOrientation)preferredInterfaceOrientationForPresentation
{
    return UIInterfaceOrientationPortrait;
}


- (void)playerWillEnterFullscreen: (NSNotification *)aNotification
{
    
    //CGAffineTransform landscapeTransform = CGAffineTransformMakeRotation(M_PI / 2);
    //player.view.transform = landscapeTransform;
    [[UIApplication sharedApplication] setStatusBarOrientation:UIInterfaceOrientationLandscapeRight animated:NO];
}
/*
- (void)playerWillExitFullscreen: (NSNotification *)aNotification
{
    CGAffineTransform portraitTransform = CGAffineTransformMakeRotation(0);
    //player.view.transform = portraitTransform;
}
*/

-(void) webViewDidFinishLoad:(UIWebView *)webView
{
    //"myVideo.requestFullscreen();"
    NSLog(@"webViewDidFinishLoad 2");
    [waitView hide];

    [self.webView stringByEvaluatingJavaScriptFromString:@"var script = document.createElement('script');"
     "script.type = 'text/javascript';"
     "script.text = \"function playVideo() { "
     "var myVideo=document.getElementById('myVideo');"
     "myVideo.play();"

     "}\";"
     "document.getElementsByTagName('head')[0].appendChild(script);"];
    [webView stringByEvaluatingJavaScriptFromString:@"playVideo();"];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

-(void) viewDidDisappear:(BOOL)animated
{
    //NSLog(@"媒体打开窗口被隐藏");
    //[self.webView loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:@"about:blank"]]];
    
}

@end
